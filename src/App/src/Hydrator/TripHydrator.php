<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 15:43
 */

namespace App\Hydrator;

use App\Entity\Courier;
use App\Entity\Region;
use App\Entity\Trip;
use Doctrine\ORM\EntityManager;
use DateTime;
use Zend\Stdlib\Parameters;

/**
 * Class TripHydrator
 * @package App\Hydrator
 */
class TripHydrator implements HydratorInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * TripHydrator constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param array $data
     * @param Trip $trip
     * @return Trip
     */
    public function hydrate(array $data, $trip)
    {
        $data = new Parameters($data);

        $region = $data->get('region');
        if (! $region instanceof Region) {
            $region = $this->entityManager->find(Region::class, $region);
        }
        $trip->setRegion($region);

        $sentDateTime = $data->get('sent_date_time');
        if (! $sentDateTime instanceof DateTime) {
            $sentDateTime = DateTime::createFromFormat('d.m.Y H:i', $sentDateTime);
        }
        $trip->setSentDateTime($sentDateTime);

        $returnDateTime = $data->get('return_date_time');
        if (! $returnDateTime instanceof DateTime) {
            $returnDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $returnDateTime);
        }
        $trip->setReturnDateTime($returnDateTime);

        $courier = $data->get('courier');
        if (! $courier instanceof  Courier) {
            $courier = $this->entityManager->find(Courier::class, $courier);
        }
        $trip->setCourier($courier);
        return $trip;
    }
}
