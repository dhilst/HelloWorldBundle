<?php

declare(strict_types=1);

namespace MauticPlugin\HelloWorldBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CampaignBundle\Event as Events;
use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;
use Mautic\CampaignBundle\Entity\Event as CampaignEvent;

use MauticPlugin\HelloWorldBundle\HelloWorldEvents;
use MauticPlugin\HelloWorldBundle\Form\Type\ExampleDecisionType;

/**
 * Class CampaignSubscriber
 */
class CampaignSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            CampaignEvents::CAMPAIGN_ON_BUILD => array('onCampaignBuild', 0),
            HelloWorldEvents::BLASTOFF        => array('executeCampaignAction', 0),
            HelloWorldEvents::DECISION => array('onDecision', 0),
        );
    } /** Add campaign decision and actions
     *
     * @param Events\CampaignBuilderEvent $event
     */
    public function onCampaignBuild(Events\CampaignBuilderEvent $event)
    {
        // Register custom action
        $event->addAction(
            'helloworld.send_offworld',
            array(
                'eventName'       => HelloWorldEvents::BLASTOFF,
                'label'           => 'plugin.helloworld.blastoff',
                'description'     => 'plugin.helloworld.blastoff.desc',
                'formType'        => false,
            )
        );

        // Register custom action
        $event->addDecision(
            'helloworld.decision_example_hit',
            array(
                'eventName'       => HelloWorldEvents::DECISION,
                'label'           => 'plugin.helloworld.decision',
                'description'     => 'plugin.helloworld.decision.desc',
                'formType'        => ExampleDecisionType::class,
            )
        );
    }

    /**
     * Execute campaign action
     *
     * @param CampaignExecutionEvent $event
     */
    public function executeCampaignAction(CampaignExecutionEvent $event)
    {
        // Do blastoff
        $now = date("c");
        $this->logger->info("==> BLASTOFF $now");
        $event->setResult(false);
    }

    // Decision is not executed on mautic:campaign:trigger. It's executed (in this case)
    // during the  $realTimeExecutioner->execute("helloworld.decision_example_hit", [], 'hellochannel', $channelId);
    // call in ApiExampleController. We need to get the channel and compare with logger channel call
    // $event->setResult(true) if the event were triggerred, or $event->setResult(false) when was not triggered
    public function onDecision(CampaignExecutionEvent $event)
    {
        $lead = $event->getLead();
        $leadId = $lead->getId();

        // These are the ExampleDecisionType form inputs
        $properties = $event->getConfig()["properties"];

        // This is the My parameter input at ExampleDecisionType on
        $myparameter = $properties["myparameter"];
        $channelId = $leadId.$myparameter;

        // These are setted before the event is built
        $log = $event->getLog();
        $logChannel = $log->getChannel();
        $logChannelId = $log->getChannelId();

        // This is custom parameters passed in the request, it can be retrieved
        // by $event->getPassThrough() method. I'm not using it here, it's just
        // an example, it may be useful
        $customParameters = $event->getPassThrough();
        return $event->setResult("hellochannel" === $logChannel && $channelId === $logChannelId);
    }
}
