<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 15.12.17
 * Time: 2:19
 */
namespace Core;

use Interop\Container\ContainerInterface;

/**
 * Class ApplicationFactory
 * @package Core
 */
class ApplicationFactory
{
    /**
     * @param ContainerInterface $container
     * @return Application
     */
    public static function create(ContainerInterface $container): Application
    {
        return new Application($container);
    }
}
