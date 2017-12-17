<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 20:35
 */

namespace App\Service;

use Doctrine\ORM\EntityManager;

abstract class AbstractService
{
    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
