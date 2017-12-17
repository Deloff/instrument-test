<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 20:06
 */
require __DIR__ . '/../vendor/autoload.php';
$configFiles = glob(__DIR__ . '/../config/{,*.}{global,local}.php', GLOB_BRACE);
$config = [];
foreach ($configFiles as $file) {
    $arr = require_once $file;
    $config = array_merge_recursive($config, $arr);
}

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions($config['DI']);
$container = $containerBuilder->build();
$container->set('config', $config);

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = $container->get(\Doctrine\ORM\EntityManager::class);

$date = new \DateTime('2015-06-01 00:00:00');

$now = new \DateTime('now');
/** @var \App\Service\CourierService $courierService */
$courierService = $container->get(\App\Service\CourierService::class);
$couriers = $courierService->getCouriers();

/** @var \App\Service\RegionService $regionService */
$regionService = $container->get(\App\Service\RegionService::class);
$regions = $regionService->getRegions();

/** @var \App\Service\TripService $tripService */
$tripService = $container->get(\App\Service\TripService::class);

/** @var \App\Repository\CourierRepository $courierRepository */
$courierRepository = $entityManager->getRepository(\App\Entity\Courier::class);
while(true) {
    if ($date > $now) {
        break;
    }
    $trips = rand(1, count($couriers));

    for($i = 1; $i <= $trips; $i++) {
        $region = $regions[$i-1];
        $freeCouriers = $courierService->getFreeCouriers($date, $region);
        if (count($freeCouriers) === 0) {
            while(true) {
                $nextDay = clone $date;
                $nextDay->modify('+1 day');
                $freeCouriers = $courierService->getFreeCouriers($date, $region);
                if (count($freeCouriers) > 0) {
                    $courierKey = array_rand($freeCouriers);
                    $tripService->saveTrip([
                        'sent_date_time' => $date->format('d.m.Y H:i'),
                        'region' => $region,
                        'courier' => $freeCouriers[$courierKey]['id']
                    ]);
                    break;
                }
            }
            continue;
        }
        $courierKey = array_rand($freeCouriers);
        $tripService->saveTrip([
            'sent_date_time' => $date->format('d.m.Y H:i'),
            'region' => $region,
            'courier' => $freeCouriers[$courierKey]['id']
        ]);
    }

    $date->modify('+1 day');
}
