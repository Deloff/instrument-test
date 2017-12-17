<?php

namespace Core;

use Core\Exception\ApplicationException\InvalidMiddlewareException;
use Core\Exception\ApplicationException\NotFoundException;
use Core\Middleware\TerminateMiddlewareInterface;
use Interop\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class Application
 * @package Core
 */
class Application
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Запуск приложения
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run()
    {
        $router = $this->getContainer()->get(Router::class);
        try {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $actions = $router->handle($uri);
            if (count($actions) === 0) {
                throw new NotFoundException(
                    sprintf('Page "%s" not found', $uri)
                );
            }
            foreach ($actions as $actionName) {
                if (! $this->getContainer()->has($actionName)) {
                    throw new NotFoundException(
                        sprintf('Middleware %s not found', $actionName)
                    );
                }
                /** @var MiddlewareInterface $action */
                $action = $this->getContainer()->get($actionName);
                if (! $action instanceof MiddlewareInterface) {
                    throw new InvalidMiddlewareException(
                        sprintf(
                            '"%s" должен реализовывать %s',
                            $actionName,
                            MiddlewareInterface::class
                        )
                    );
                }
                $request = ServerRequestFactory::fromGlobals();

                $content = $action->process($request, new RequestHandler());
                if ($content instanceof ResponseInterface) {
                    $contentData = $content->getBody()->getContents();
                    if ($action instanceof TerminateMiddlewareInterface && $action->isTerminate()) {
                        echo $contentData;
                    } else {
                        $twig = $this->getContainer()->get('twig');

                        echo $twig->render('layout.twig', ['content' => $contentData]);
                    }
                    break;
                }
            }
        } catch (\Exception $e) {
            //@TODO add whoops
            echo $e->getMessage();
            die;
        }
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
