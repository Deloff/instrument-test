<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 16:02
 */
namespace Core;

use Core\Exception\EntityManagerException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Interop\Container\ContainerInterface;

/**
 * Class EntityManagerFactory
 * @package Core
 */
class EntityManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container): EntityManager
    {
        /** @var array $config */
        $config = $container->get('config');
        if (! array_key_exists('doctrine', $config)) {
            throw new EntityManagerException('В конфигурации на задана секция "doctrine"');
        }
        $doctrineConfig = $config['doctrine'];
        if (! array_key_exists('connection', $doctrineConfig)) {
            throw new EntityManagerException('Нет секции "connection" для doctrine');
        }
        $dbParams = $doctrineConfig['connection'];

        if (! array_key_exists('entities', $doctrineConfig)) {
            throw new EntityManagerException('Не заданы папки с entity в секции "doctrine"');
        }
        $entities = $doctrineConfig['entities'];

        $isDevMode = isset($doctrineConfig['isDevMode']) ? $doctrineConfig['isDevMode'] : false;
        $config = Setup::createAnnotationMetadataConfiguration(
            $entities,
            $isDevMode,
            null,
            null,
            false
        );
        $entityManager = EntityManager::create($dbParams, $config);
        return $entityManager;
    }
}
