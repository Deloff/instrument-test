<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 15.12.17
 * Time: 0:31
 */
namespace Core;

use Core\Exception\RouterException\InvalidRouteConfigException;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * @var array
     */
    protected $routes;


    /**
     * Router constructor.
     * @param array $routeConfig
     */
    public function __construct(array $routeConfig)
    {
        $this->routes = $routeConfig;
    }

    /**
     * Находит роут согласно кофнигу и возвращает список Middleware
     *
     * @param string $uri
     * @return array
     */
    public function handle(string $uri): array
    {
        $result = [];
        $routes = $this->getRoutes();
        foreach ($routes as $key => $route) {
            $type = 'literal';

            if (array_key_exists('type', $route) && $route['type'] && is_string($route['type'])) {
                $type = $route['type'];
            }

            if (! array_key_exists('link', $route) || ! $route['link']) {
                throw new InvalidRouteConfigException(
                    sprintf('Не задан параметр "link" для роута %s', $key)
                );
            }
            $link = $route['link'];

            if (! array_key_exists('actions', $route) || ! is_array($route['actions'])) {
                throw new InvalidRouteConfigException(
                    sprintf('Не задана секция "actions" в роуте %s', $key)
                );
            }
            $actions = $route['actions'];
            $founded = false;
            switch (strtolower($type)) {
                case 'literal':
                    if ($link === $uri) {
                        $founded = true;
                        $result = $actions;
                    }
                    break;
                case 'regular':
                    if (preg_match($link, $uri)) {
                        $founded = true;
                        $result = $actions;
                    }
            }
            if ($founded) {
                break;
            }
        }
        return $result;
    }

    /**
     * Проверяет что роут существует по его имени
     *
     * @param string $routeName
     * @return bool
     */
    public function has(string $routeName): bool
    {
        return array_key_exists($routeName, $this->getRoutes());
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }
}
