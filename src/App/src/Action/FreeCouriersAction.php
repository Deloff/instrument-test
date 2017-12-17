<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 14:13
 */

namespace App\Action;

use App\Entity\Region;
use App\Service\CourierService;
use App\Service\RegionService;
use Core\Middleware\TerminateMiddlewareInterface;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stdlib\Parameters;
use RuntimeException;

class FreeCouriersAction implements MiddlewareInterface, TerminateMiddlewareInterface
{
    /**
     * @var RegionService
     */
    protected $regionService;

    /**
     * @var CourierService
     */
    protected $courierService;

    /**
     * FreeCouriersAction constructor.
     * @param RegionService $regionService
     * @param CourierService $courierService
     */
    public function __construct(RegionService $regionService, CourierService $courierService)
    {
        $this->regionService = $regionService;
        $this->courierService = $courierService;
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
        try {
            $params = new Parameters($request->getQueryParams());
            $regionId = $params->get('region', null);
            $sentDate = $params->get('sent_date', null);
            if (! $sentDate) {
                throw new RuntimeException('Не указана дата поездки');
            }
            if (! $regionId) {
                throw new RuntimeException('Не указан регион');
            }
            /** @var Region $region */
            $region = $this->regionService->getRegionById((int)$regionId);
            if (! $region) {
                throw new RuntimeException(
                    sprintf('Регион с id %d не найден', $regionId)
                );
            }
            $sentDate = \DateTime::createFromFormat('d.m.Y H:i', $sentDate);
            $couriers = $this->courierService->getFreeCouriers($sentDate, $region);
            $res = [
                'status' => 'success',
                'couriers' => $couriers

            ];
        } catch (\Exception $e) {
            $res = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
        return new JsonResponse($res);
    }

    /**
     * @return bool
     */
    public function isTerminate(): bool
    {
        return true;
    }
}
