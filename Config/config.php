<?php

return array(
    'name'        => 'HelloWorld plugin',
    'description' => 'Hello World plugin',
    'author'      => 'Daniel Hilst Selli',
    'version'     => '1.0.1',
    'routes' => [
        'api' => [
            'plugin_helloworld_decision_hit' => [
                'path'       => '/helloworld/decisionhit',
                'controller' => 'HelloWorldBundle:Api\ApiExample:decisionhit',
                'method'     => 'POST'
            ]
        ],
    ],
    'services'    => array(
        'events' => array(
            'plugin.helloworld.campaignbundle.subscriber' => array(
                'class' => 'MauticPlugin\HelloWorldBundle\EventListener\CampaignSubscriber',
                'arguments' => [
                                        'doctrine.orm.entity_manager',
                ],
            )
        ),
    ),
);
