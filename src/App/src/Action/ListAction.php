<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 14.12.17
 * Time: 1:44
 */

namespace App\Action;

use App\Service\TripService;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Stdlib\Parameters;

/**
 * Class ListAction
 * @package App\Action
 */
class ListAction implements MiddlewareInterface
{

    /**
     * @var TripService
     */
    protected $tripService;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * ListAction constructor.
     * @param TripService $tripService
     * @param \Twig_Environment $twig
     */
    public function __construct(TripService $tripService, \Twig_Environment $twig)
    {
        $this->tripService = $tripService;
        $this->twig = $twig;
    }


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = new Parameters($request->getQueryParams());

        $page = $params->get('page', 1);
        $onPage = 25;

        $sentFrom = $params->get('sent_from', null);
        $sentTo = $params->get('sent_to', null);

        if ($sentFrom) {
            $sentFrom = \DateTime::createFromFormat('d.m.Y H:i', $sentFrom);
        }
        $sentFrom = $sentFrom instanceof \DateTime ? $sentFrom : null;

        if ($sentTo) {
            $sentTo = \DateTime::createFromFormat('d.m.Y H:i', $sentTo);
        }
        $sentTo = $sentTo instanceof \DateTime ? $sentTo : null;
        $tripService = $this->getTripService();
        $counter = $tripService->getCount($sentFrom, $sentTo);
        $data = $tripService->getList($sentFrom, $sentTo, $onPage, ($page - 1) * $onPage);
        $value = $this->getTwig()
            ->render('list.twig', [
                'data' => $data,
                'pages' => ceil($counter / $onPage),
                'page' => $page,
                'sent_from' => $sentFrom ? $sentFrom->format('d.m.Y H:i') : '',
                'sent_to' => $sentTo ? $sentTo->format('d.m.Y H:i') : ''
            ]);
        return new HtmlResponse($value);
    }

    /**
     * @return TripService
     */
    public function getTripService(): TripService
    {
        return $this->tripService;
    }

    /**
     * @param TripService $tripService
     */
    public function setTripService(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig(): \Twig_Environment
    {
        return $this->twig;
    }
}
