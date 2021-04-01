<?php

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

        if (!$req->has("debtorid")) {
            return $this->handleView($this->view("Missing debtorid", 400));
        }

        // Get the request parameters
        $parms = $req->all();
        $debtorId = $parms["debtorid"];

        $tracker = $this->get("mautic.tracker.contact");
        $leadRepo = $this->get("mautic.lead.repository.lead");
        $leads = $leadRepo->getLeadsByFieldValue("debtorid", $debtorId);

        if (empty($leads)) {
            return $this->handleView($this->view("Lead not found", 204));
        }

        $lead = reset($leads); // reset return the first item on array if present
        $tracker->setTrackedContact($lead);

        $realTimeExecutioner = $this->get("mautic.campaign.executioner.realtime");
        $realTimeExecutioner->execute("helloworld.decision_example_hit", [], 'hellochannel', $debtorId);

        // Return HTTP 200
        return $this->handleView($this->view("Ok", 200));
    }
}
