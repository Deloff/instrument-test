<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:26
 */

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class CourierserviceFactory
 * @package App\Service
 */
class CourierserviceFactory
{
    /**
     * @param ContainerInterface $container
     * @return CourierService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container): CourierService
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new CourierService($entityManager);
    }
}
