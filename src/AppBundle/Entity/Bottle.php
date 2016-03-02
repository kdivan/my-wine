<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="bottle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BottleRepository")
 */
class Bottle
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
     * @var string
     *
     * @ORM\Column(name="vineyard", type="string", length=255)
     */
    private $vineyard;

    /**
     * @var string
     *
     * @ORM\Column(name="winemaking", type="string", length=255)
     */
    private $winemaking;

    /**
     * @var string
     *
     * @ORM\Column(name="buying_price", type="string", length=255)
     */
    private $buyingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="cellar_id", type="string", length=255)
     */
    private $cellarId;

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
     * @return Bottle
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
     * Set description
     *
     * @param string $description
     *
     * @return Bottle
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set vineyard
     *
     * @param string $vineyard
     *
     * @return Bottle
     */
    public function setVineyard($vineyard)
    {
        $this->vineyard = $vineyard;

        return $this;
    }

    /**
     * Get vineyard
     *
     * @return string
     */
    public function getVineyard()
    {
        return $this->vineyard;
    }

    /**
     * Set winemaking
     *
     * @param string $winemaking
     *
     * @return Bottle
     */
    public function setWinemaking($winemaking)
    {
        $this->winemaking = $winemaking;

        return $this;
    }

    /**
     * Get winemaking
     *
     * @return string
     */
    public function getWinemaking()
    {
        return $this->winemaking;
    }

    /**
     * Set buyingPrice
     *
     * @param string $buyingPrice
     *
     * @return Bottle
     */
    public function setBuyingPrice($buyingPrice)
    {
        $this->buyingPrice = $buyingPrice;

        return $this;
    }

    /**
     * Get buyingPrice
     *
     * @return string
     */
    public function getBuyingPrice()
    {
        return $this->buyingPrice;
    }

    /**
     * @return string
     */
    public function getCellarId()
    {
        return $this->cellarId;
    }

    /**
     * @param string $cellarId
     */
    public function setCellarId($cellarId)
    {
        $this->cellarId = $cellarId;
    }

}

