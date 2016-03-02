<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cellar
 *
 * @ORM\Table(name="cellar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CellarRepository")
 */
class Cellar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="max_bottles", type="integer")
     */
    private $maxBottles;

    /**
     * @ORM\OneToMany(targetEntity="Bottle", mappedBy="cellar")
     */
    protected $bottles;

    public function __construct()
    {
        $this->bottles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Cellar
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBottles()
    {
        return $this->bottles;
    }

    /**
     * @param mixed $bottles
     */
    public function setBottles($bottles)
    {
        $this->bottles = $bottles;
    }

    /**
     * @return int
     */
    public function getMaxBottles()
    {
        return $this->maxBottles;
    }

    /**
     * @param int $maxBottles
     */
    public function setMaxBottles($maxBottles)
    {
        $this->maxBottles = $maxBottles;
    }
}
