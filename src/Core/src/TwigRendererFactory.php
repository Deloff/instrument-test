<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 17:56
 */
namespace Core;

use Core\Exception\TwigRendererException\ConfigurationException;
use Interop\Container\ContainerInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigRendererFactory
{
    public static function create(ContainerInterface $container): Twig_Environment
    {
        /** @var array $config */
        $config = $container->get('config');
        if (! array_key_exists('twig', $config) || ! is_array($config['twig'])) {
            throw new ConfigurationException('Не задана конфигурация для "twig"');
        }
        /** @var array $twigConfig */
        $twigConfig = $config['twig'];

        if (! array_key_exists('templates', $twigConfig) || ! is_array($twigConfig['templates'])) {
            throw new ConfigurationException(
                'В конфигурации не указаны папки с шаблонами [twig][templates]'
            );
        }
        $twigTemplates = $twigConfig['templates'];

        if (! array_key_exists('compiled_cache', $twigConfig) || ! is_array($twigConfig['compiled_cache'])) {
            throw new ConfigurationException(
                'В конфигурации не указаны пути до кэша twig [twig][compiled_cache]'
            );
        }
        $cache = $twigConfig['compiled_cache'];
        $loader = new Twig_Loader_Filesystem($twigTemplates);
        $twig = new Twig_Environment($loader, $cache);
        return $twig;
    }
}
