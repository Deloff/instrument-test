<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 17:30
 */

namespace App\Service;

use App\Hydrator\HydratorInterface;
use App\Hydrator\TripHydrator;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class TripServiceFactory
 * @package App\Service
 */
class TripServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return TripService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container): TripService
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        /** @var HydratorInterface $hydrator */
        $hydrator = $container->get(TripHydrator::class);
        $tripService = new TripService($hydrator, $entityManager);
        return $tripService;
    }
}
