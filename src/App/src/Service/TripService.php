<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 16:14
 */

namespace App\Service;

use App\Entity\Region;
use App\Entity\Trip;
use App\Hydrator\HydratorInterface;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Parameters;

/**
 * Class TripService
 * @package App\Service
 */
class TripService
{
    /**
     * @var  HydratorInterface
     */
    private $hydrator;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * TripService constructor.
     * @param HydratorInterface $hydrator
     * @param EntityManager $entityManager
     */
    public function __construct(HydratorInterface $hydrator, EntityManager $entityManager)
    {
        $this->hydrator = $hydrator;
        $this->entityManager = $entityManager;
    }


    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     * @return array
     */
    public function getList(\DateTime $from = null, \DateTime $to = null, int $limit = 0, int $offset = 0):array
    {
        /** @var TripRepository $tripRepo */
        $tripRepo = $this->entityManager->getRepository(Trip::class);
        return $tripRepo->getTripsBySentDates($from, $to, $limit, $offset);
    }

    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     * @return int
     */
    public function getCount(\DateTime $from = null, \DateTime $to = null): int
    {
        /** @var TripRepository $tripRepo */
        $tripRepo = $this->entityManager->getRepository(Trip::class);
        return $tripRepo->getCountBySentDates($from, $to);
    }

    /**
     * @param \DateTime $sentDate
     * @param Region $region
     * @return \DateTime
     */
    public function calculateReturnDate(\DateTime $sentDate, Region $region)
    {
        $regionDate = $this->calculateRegionDate($sentDate, $region);
        $regionDate->modify('+' . $region->getReturnTime() / 3600 . ' hour');
        return $regionDate;
    }

    /**
     * @param \DateTime $sentDate
     * @param Region $region
     * @return \DateTime
     */
    public function calculateRegionDate(\DateTime $sentDate, Region $region)
    {
        $sentDate->modify('+' . $region->getTravelTime() / 3600 . ' hour');
        return $sentDate;
    }

    /**
     * @param array $data
     * @param Trip|null $trip
     * @return Trip|null|object
     */
    public function saveTrip(array $data, Trip $trip = null)
    {
        $parameters = new Parameters($data);
        if (! $trip) {
            $trip = new Trip();
        }
        /** @var Region $region */
        $region = $this->getEntityManager()->find(Region::class, $parameters->get('region'));
        $sentDateTime = $parameters->get('sent_date_time');
        $sentDateTime = \DateTime::createFromFormat('d.m.Y H:i', $sentDateTime);
        if (! $sentDateTime) {
            throw new \RuntimeException('Некорректная дата и время');
        }
        $returnDateTime = clone $sentDateTime;
        $returnDateTime->modify('+' . $region->getTravelTime() . ' second');
        $returnDateTime->modify('+' . $region->getReturnTime() . ' second');
        $parameters->set('return_date_time', $returnDateTime);

        $trip = $this->hydrator->hydrate($parameters->toArray(), $trip);
        $this->entityManager->persist($trip);
        $this->entityManager->flush($trip);
        return $trip;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * @param HydratorInterface $hydrator
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
