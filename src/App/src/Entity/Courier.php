<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 15:45
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Courier
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\CourierRepository")
 * @ORM\Table(name="courier")
 */
class Courier
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false, name="id")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * Фамилия
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * Имя
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * Отчестов
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="middle_name")
     */
    private $middleName;

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
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName(string $middleName)
    {
        $this->middleName = $middleName;
    }
}
