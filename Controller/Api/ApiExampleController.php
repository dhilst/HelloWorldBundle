<?php

declare(strict_types=1);

namespace MauticPlugin\HelloWorldBundle\Controller\Api;

use FOS\RestBundle\Util\Codes;
use Mautic\ApiBundle\Controller\CommonApiController;
use Mauitc\LeadBundle\Entity\Lead;

class ApiExampleController extends CommonApiController
{

    /**
     * Get a list of worlds
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function decisionhitAction()
    {
        $req = $this->request->request; // POST parameters

        if (!$req->has("leadId") || !$req->has("myparameter")) {
            return $this->handleView($this->view("Missing leadId or myparameter", 400));
        }

        // Get the request parameters
        $parms = $req->all();
        $passthrough = isset($parms["customParameters"]) ? $parms["customParameters"] : null;
        $leadId = $parms["leadId"];
        $myparameter  = $parms["myparameter"];
        $channelId = $leadId.$myparameter;
        $tracker = $this->get("mautic.tracker.contact");
        $leadRepo = $this->get("mautic.lead.repository.lead");
        $lead = $leadRepo->find($leadId);

        $tracker->setTrackedContact($lead);

        $realTimeExecutioner = $this->get("mautic.campaign.executioner.realtime");
        $realTimeExecutioner->execute("helloworld.decision_example_hit", $passthrough, 'hellochannel', $channelId);

        // Return HTTP 200
        return $this->handleView($this->view("Ok", 200));
    }
}
