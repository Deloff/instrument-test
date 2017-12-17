<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:12
 */

namespace App\Action;

use App\Service\CourierService;
use App\Service\RegionService;
use App\Service\TripService;
use Interop\Container\ContainerInterface;

/**
 * Class AddTripActionFactory
 * @package App\Action
 */
class AddTripActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return AddTripAction
     */
    public static function create(ContainerInterface $container)
    {
        /** @var TripService $tripService */
        $tripService = $container->get(TripService::class);

        /** @var \Twig_Environment $twig */
        $twig = $container->get('twig');
        /** @var RegionService $regionService */
        $regionService = $container->get(RegionService::class);
        /** @var CourierService $courierService */
        $courierService = $container->get(CourierService::class);
        return new AddTripAction($twig, $tripService, $courierService, $regionService);
    }
}
