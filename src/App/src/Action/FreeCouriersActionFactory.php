<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 14:55
 */

namespace App\Action;

use App\Service\CourierService;
use App\Service\RegionService;
use Interop\Container\ContainerInterface;

class FreeCouriersActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return FreeCouriersAction
     */
    public static function create(ContainerInterface $container): FreeCouriersAction
    {
        /** @var RegionService $regionService */
        $regionService = $container->get(RegionService::class);
        /** @var CourierService $courierService */
        $courierService = $container->get(CourierService::class);
        return new FreeCouriersAction($regionService, $courierService);
    }
}
