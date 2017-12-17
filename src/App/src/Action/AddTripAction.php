<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:09
 */

namespace App\Action;

use App\Service\CourierService;
use App\Service\RegionService;
use App\Service\TripService;
use Core\Middleware\TerminateMiddlewareInterface;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class AddTripAction implements MiddlewareInterface, TerminateMiddlewareInterface
{
    /** @var \Twig_Environment */
    protected $twig;

    /**
     * @var TripService
     */
    protected $tripService;

    /**
     * @var CourierService
     */
    protected $courierService;

    /**
     * @var RegionService
     */
    protected $regionService;

    /**
     * AddTripAction constructor.
     * @param \Twig_Environment $twig
     * @param TripService $tripService
     * @param CourierService $courierService
     * @param RegionService $regionService
     */
    public function __construct(
        \Twig_Environment $twig,
        TripService $tripService,
        CourierService $courierService,
        RegionService $regionService
    ) {
        $this->twig = $twig;
        $this->tripService = $tripService;
        $this->courierService = $courierService;
        $this->regionService = $regionService;
    }


    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = $request->getMethod();
        switch ($method) {
            case 'POST':
                $data = $request->getParsedBody();
                try {
                    $this->tripService->saveTrip($data);
                    $res = ['status' => 'success'];
                } catch (\Exception $e) {
                    $res = [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                }
                return new JsonResponse($res);
                break;
            case 'GET':
                $regions = $this->getRegionService()->getRegions();
                $couriers = $this->getCourierService()->getCouriers();
                $content = $this->getTwig()->render('add-trip.twig', [
                    'couriers' => $couriers,
                    'regions' => $regions
                ]);
                return new HtmlResponse($content);
                break;
        }
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
     * @return CourierService
     */
    public function getCourierService(): CourierService
    {
        return $this->courierService;
    }

    /**
     * @param CourierService $courierService
     */
    public function setCourierService(CourierService $courierService)
    {
        $this->courierService = $courierService;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig(): \Twig_Environment
    {
        return $this->twig;
    }

    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return RegionService
     */
    public function getRegionService(): RegionService
    {
        return $this->regionService;
    }

    /**
     * @param RegionService $regionService
     */
    public function setRegionService(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * @return bool
     */
    public function isTerminate(): bool
    {
        return true;
    }
}
