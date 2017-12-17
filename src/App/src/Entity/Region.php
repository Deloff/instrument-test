<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 15:59
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Region
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="region")
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="return_time", type="integer", nullable=false)
     */
    private $returnTime;

    /**
     * @var int
     *
     * @ORM\Column(name="travel_time", type="integer", nullable=false)
     */
    private $travelTime;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getReturnTime(): int
    {
        return $this->returnTime;
    }

    /**
     * @param int $returnTime
     */
    public function setReturnTime(int $returnTime)
    {
        $this->returnTime = $returnTime;
    }

    /**
     * @return int
     */
    public function getTravelTime(): int
    {
        return $this->travelTime;
    }

    /**
     * @param int $travelTime
     */
    public function setTravelTime(int $travelTime)
    {
        $this->travelTime = $travelTime;
    }
}
