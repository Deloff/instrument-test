<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 0:43
 */
namespace Core;

use Core\Exception\RouterException\InvalidRouteConfigException;
use Interop\Container\ContainerInterface;

/**
 * Class RouterFactory
 * @package Core
 */
class RouterFactory
{

    /**
     * @param ContainerInterface $container
     * @return Router
     */
    public static function create(ContainerInterface $container): Router
    {
        $config = $container->get('config');
        if (! array_key_exists('router', $config) || ! is_array($config['router'])) {
            throw new InvalidRouteConfigException(
                'Не задана или некорректная секция "router" в конфигe'
            );
        }
        /** @var array $routerConfig */
        $routerConfig = $config['router'];
        if (! array_key_exists('routes', $routerConfig) || ! is_array($routerConfig['routes'])) {
            throw new InvalidRouteConfigException(
                'Не задана секция "routes" в конфигурации роутера'
            );
        }
        $routes = $routerConfig['routes'];
        return new Router($routes);
    }
}
