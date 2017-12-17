<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:25
 */

namespace App\Service;

use App\Entity\Courier;
use App\Entity\Region;
use App\Repository\CourierRepository;

class CourierService extends AbstractService
{
    /**
     * @return array
     */
    public function getCouriers(): array
    {
        return $this->entityManager
            ->getRepository(Courier::class)
            ->findAll();
    }

    /**
     * @param \DateTime $sentDate
     * @param Region $region
     * @return array
     */
    public function getFreeCouriers(\DateTime $sentDate, Region $region)
    {
        /** @var CourierRepository $courierRepo */
        $courierRepo = $this->getEntityManager()->getRepository(Courier::class);
        return $courierRepo->getFreeCouriersByDate($sentDate, $region);
    }
}
