<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:35
 */

namespace App\Service;

use App\Entity\Region;

/**
 * Class RegionService
 * @package App\Service
 */
class RegionService extends AbstractService
{
    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->getEntityManager()
            ->getRepository(Region::class)
            ->findAll();
    }

    /**
     * @param int $regionId
     * @return null|object
     */
    public function getRegionById(int $regionId)
    {
        return $this->getEntityManager()
            ->getRepository(Region::class)
            ->find($regionId);
    }
}
