<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 16:16
 */

namespace App\Hydrator;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class TripHydratorFactory
 * @package App\Hydrator
 */
class TripHydratorFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new TripHydrator($entityManager);
    }
}
