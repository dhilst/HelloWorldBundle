<?php
// plugins/HelloWorldBundle/EventListener/CampaignSubscriber.php

namespace MauticPlugin\HelloWorldBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CampaignBundle\Event as Events;
use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;

use MauticPlugin\HelloWorldBundle\HelloWorldEvents;

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
    }

    /**
     * Add campaign decision and actions
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
                'label'           => 'HelloWorld - Blast off',
                'description'     => 'Blasting off',
                'formType'        => false,
            )
        );

        // Register custom action
        $event->addDecision(
            'helloworld.decision_example',
            array(
                'eventName'       => HelloWorldEvents::DECISION,
                'label'           => 'HelloWorld - Decision',
                'description'     => 'Decision Example',
                'formType'        => false,
            )
        );
    }

    /**
     * Execute campaign action
     *
     * @param CampaignExecutionEvent $event
     */
    public function executeCampaignAction (CampaignExecutionEvent $event)
    {
        // Do blastoff
        $now = date("c");
        $this->logger->info("==> BLASTOFF $now");
        $event->setResult(false);
    }

    public function onDecsision(CampaignExecutionEvent $event)
    {
        $event->setResult(true);
    }
}
