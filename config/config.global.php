<?php

return [
    'router' => [
        'routes' => [
            'list' => [
                'type' => 'literal',
                'link' => '/',
                'actions' => [
                    \App\Action\ListAction::class
                ]
            ],
            'add_trip' => [
                'type' => 'literal',
                'link' => '/addTrip',
                'actions' => [
                    \App\Action\AddTripAction::class
                ]
            ],
            'calculate-date' => [
                'type' => 'literal',
                'link' => '/addTrip/calculateDate',
                'actions' => [
                    \App\Action\RegionDateTimeAction::class
                ]
            ],
            'free-couriers' => [
                'type' => 'literal',
                'link' => '/addTrip/freeCouriers',
                'actions' => [
                    \App\Action\FreeCouriersAction::class
                ]
            ]
        ]
    ],
    'doctrine' => [
        'isDevMode' => true,
        'connection' => [
            'driver'   => 'pdo_mysql',
            'host'     => 'db',
            'user'     => 'instrument',
            'password' => 'instrument',
            'dbname'   => 'instrument',
            'charset'  => 'utf8',
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        ],
        'entities' => [
            __DIR__ . '/../src/App/src/Entity'
        ]
    ],
    'twig' => [
        'templates' => [
            __DIR__ . '/../src/App/view'
        ],
        'compiled_cache' => [
            __DIR__ . '/../data/cache'
        ]
    ],
    'DI' => [
        \Core\Router::class => DI\factory([\Core\RouterFactory::class, 'create']),
        \Core\Application::class => DI\factory([\Core\ApplicationFactory::class, 'create']),

        \Doctrine\ORM\EntityManager::class => DI\factory([\Core\EntityManagerFactory::class, 'create']),
        'twig' => \DI\factory([\Core\TwigRendererFactory::class, 'create']),

        //Services
        \App\Service\TripService::class => \DI\factory([\App\Service\TripServiceFactory::class, 'create']),
        \App\Service\CourierService::class => \DI\factory([\App\Service\CourierserviceFactory::class, 'create']),
        \App\Service\RegionService::class => \DI\factory([\App\Service\RegionServiceFactory::class, 'create']),

        //Actions
        \App\Action\ListAction::class => \DI\factory([\App\Action\ListActionFactory::class, 'create']),
        \App\Action\AddTripAction::class => \DI\factory([\App\Action\AddTripActionFactory::class, 'create']),
        \App\Action\RegionDateTimeAction::class =>
            \DI\factory([\App\Action\RegionDateTimeActionFactory::class, 'create']),
        \App\Action\FreeCouriersAction::class => \DI\factory([\App\Action\FreeCouriersActionFactory::class, 'create']),

        //Hydrators
        \App\Hydrator\TripHydrator::class => \DI\factory([\App\Hydrator\TripHydratorFactory::class, 'create'])
    ]
];