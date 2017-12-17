<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 0:32
 */

namespace App\Action;

use App\Entity\Region;
use App\Service\RegionService;
use App\Service\TripService;
use Core\Middleware\TerminateMiddlewareInterface;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stdlib\Parameters;
use RuntimeException;

/**
 * Class RegionDateTimeAction
 * @package App\Action
 */
class RegionDateTimeAction implements MiddlewareInterface, TerminateMiddlewareInterface
{

    /**
     * @var RegionService
     */
    protected $regionService;

    /**
     * @var TripService
     */
    protected $tripService;

    /**
     * ReturnDateTimeAction constructor.
     * @param RegionService $regionService
     * @param TripService $tripService
     */
    public function __construct(RegionService $regionService, TripService $tripService)
    {
        $this->regionService = $regionService;
        $this->tripService = $tripService;
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
            $date = $this->tripService->calculateRegionDate($sentDate, $region);
            $res = [
                'status' => 'success',
                'date' => $date->format('d.m.Y H:i:s')

            ];
        } catch (\Exception $e) {
            $res = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        } finally {
            return new JsonResponse($res);
        }
    }

    /**
     * @return bool
     */
    public function isTerminate(): bool
    {
        return true;
    }
}
