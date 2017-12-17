<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 17:29
 */

namespace App\Action;

use App\Service\TripService;
use Interop\Container\ContainerInterface;

/**
 * Class ListActionFactory
 * @package App\Action
 */
class ListActionFactory
{

    /**
     * @param ContainerInterface $container
     * @return ListAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container): ListAction
    {
        /** @var TripService $tripService */
        $tripService = $container->get(TripService::class);

        /** @var \Twig_Environment $twig */
        $twig = $container->get('twig');
        return new ListAction($tripService, $twig);
    }
}
