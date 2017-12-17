<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 17:14
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TripRepository
 * @package App\Repository
 */
class TripRepository extends EntityRepository
{
    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getTripsBySentDates(\DateTime $from = null, \DateTime $to = null, int $limit = 0, int $offset = 0)
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb->select([
            't.*',
            'r.name as region_name',
            'c.last_name',
            'c.first_name',
            'c.middle_name',
            'DATE_ADD(t.sent_date_time, INTERVAL (r.return_time + r.travel_time) SECOND) as return_date_time'
        ])->from('trip', 't')
            ->join('t', 'region', 'r', 'r.id = t.region_id')
            ->join('t', 'courier', 'c', 'c.id = t.courier_id')
            ->orderBy('t.sent_date_time', 'desc');
        if ($from) {
            $qb->andWhere('sent_date_time >= :from')
                ->setParameter('from', $from->format('Y-m-d H:i:s'));
        }
        if ($to) {
            $qb->andWhere('sent_date_time <= :to')
                ->setParameter('to', $to->format('Y-m-d H:i:s'));
        }
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        if ($offset) {
            $qb->setFirstResult($offset);
        }
        return $qb->execute()->fetchAll();
    }

    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     * @return int
     */
    public function getCountBySentDates(\DateTime $from = null, \DateTime $to = null): int
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb->select([
            'count(*)'
        ])->from('trip', 't')
            ->join('t', 'region', 'r', 'r.id = t.region_id')
            ->join('t', 'courier', 'c', 'c.id = t.courier_id')
            ->orderBy('t.sent_date_time', 'desc');
        if ($from) {
            $qb->andWhere('sent_date_time >= :from')
                ->setParameter('from', $from->format('Y-m-d H:i:s'));
        }
        if ($to) {
            $qb->andWhere('sent_date_time <= :to')
                ->setParameter('to', $to->format('Y-m-d H:i:s'));
        }
        return (int)$qb->execute()->fetchColumn();
    }
}
