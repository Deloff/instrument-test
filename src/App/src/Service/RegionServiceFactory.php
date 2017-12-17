<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:40
 */

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class RegionServiceFactory
 * @package App\Service
 */
class RegionServiceFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new RegionService($entityManager);
    }
}
