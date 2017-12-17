<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 1:42
 */

namespace App\Action;

use App\Service\RegionService;
use App\Service\TripService;
use Interop\Container\ContainerInterface;

/**
 * Class ReturnDateTimeActionFactory
 * @package App\Action
 */
class RegionDateTimeActionFactory
{

    /**
     * @param ContainerInterface $container
     * @return RegionDateTimeAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container)
    {
        /** @var TripService $tripService */
        $tripService = $container->get(TripService::class);
        /** @var RegionService $regionService */
        $regionService = $container->get(RegionService::class);
        return new RegionDateTimeAction($regionService, $tripService);
    }
}
