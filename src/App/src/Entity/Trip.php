<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 15:43
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Trip
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 * @ORM\Table(name="trip")
 */
class Trip
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer",nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_date_time", type="datetime")
     */
    private $sentDateTime;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date_time", type="datetime", nullable=false)
     */
    private $returnDateTime;

    /**
     * @var Courier
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Courier")
     * @ORM\JoinColumn(name="courier_id", referencedColumnName="id")
     */
    private $courier;


    /**
     * Trip constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getSentDateTime(): \DateTime
    {
        return $this->sentDateTime;
    }

    /**
     * @param \DateTime $sentDateTime
     */
    public function setSentDateTime(\DateTime $sentDateTime)
    {
        $this->sentDateTime = $sentDateTime;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @return \DateTime
     */
    public function getReturnDateTime(): \DateTime
    {
        return $this->returnDateTime;
    }

    /**
     * @param \DateTime $returnDateTime
     */
    public function setReturnDateTime(\DateTime $returnDateTime)
    {
        $this->returnDateTime = $returnDateTime;
    }

    /**
     * @return Courier
     */
    public function getCourier(): Courier
    {
        return $this->courier;
    }

    /**
     * @param Courier $courier
     */
    public function setCourier(Courier $courier)
    {
        $this->courier = $courier;
    }
}
