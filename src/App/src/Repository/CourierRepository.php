<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 14:32
 */

namespace App\Repository;

use App\Entity\Region;
use Doctrine\ORM\EntityRepository;

/**
 * Class CourierRepository
 * @package App\Repository
 */
class CourierRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateTime
     * @param Region $region
     * @return array
     */
    public function getFreeCouriersByDate(\DateTime $dateTime, Region $region)
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb->select('DISTINCT c.*')->from('courier', 'c')
            ->leftJoin('c', 'trip', 't', 'c.id = t.courier_id')
            ->where('(t.return_date_time < :sent_date')
            ->orWhere('t.sent_date_time > DATE_ADD(:sent_date, INTERVAL (:return_time + :travel_time) SECOND))')
            ->orWhere('(t.return_date_time is null AND t.sent_date_time is null)')
            ->setParameter('sent_date', $dateTime->format('Y-m-d H:i:s'))
            ->setParameter('return_time', $region->getReturnTime())
            ->setParameter('travel_time', $region->getTravelTime());
        return $qb->execute()->fetchAll();
    }
}
