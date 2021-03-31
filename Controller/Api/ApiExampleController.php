<?php

namespace MauticPlugin\HelloWorldBundle\Controller\Api;

use FOS\RestBundle\Util\Codes;
use Mautic\ApiBundle\Controller\CommonApiController;

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

        // Get the request parameters
        $parms = $req->all();
        // Get campaign model, we need this to trigger
        // the event
        $campaignModel = $this->getModel("campaign.event");

        // Trigger the checkpoint event
        //$campaignModel->triggerEvent('nisi.decision_hit', []);

        // Return HTTP 200
        return $this->handleView($this->view("Ok", 200));
    }
}
