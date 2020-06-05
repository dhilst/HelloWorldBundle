<?php

return array(
    'name'        => 'HelloWorld plugin',
    'description' => 'Hello World plugin',
    'author'      => 'Daniel Hilst Selli',
    'version'     => '1.0.0',
    'services'    => array(
        'events' => array(
            'plugin.helloworld.campaignbundle.subscriber' => array(
                'class' => 'MauticPlugin\HelloWorldBundle\EventListener\CampaignSubscriber'
            )
        ),
    ),
);
