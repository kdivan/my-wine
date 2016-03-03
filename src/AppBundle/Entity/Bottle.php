<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Bottle.
 *
 * @ORM\Table(name="bottle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BottleRepository")
 * @Vich\Uploadable
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
     * @var int
     *
     * @ORM\Column(name="buying_price", type="bigint")
     */
    private $buyingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @var int
     *
     * @ORM\Column(name="vintage", type="bigint")
     */
    private $vintage;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=50)
     */
    private $capacity;

    /**
     * @var Cellar
     *
     * @ORM\ManyToOne(targetEntity="Cellar", inversedBy="bottles")
     * @ORM\JoinColumn(name="cellar_id", referencedColumnName="id")
     */
    protected $cellar;

    /**
     * @var BottleType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BottleType", inversedBy="bottles")
     * @ORM\JoinColumn(name="bottle_type_id", referencedColumnName="id")
     */
    protected $bottleType;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="bottle_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
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
     * @return mixed
     */
    public function getCellar()
    {
        return $this->cellar;
    }

    /**
     * @param mixed $cellar
     */
    public function setCellar(Cellar $cellar)
    {
        $this->cellar = $cellar;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getVintage()
    {
        return $this->vintage;
    }

    /**
     * @param int $vintage
     */
    public function setVintage($vintage)
    {
        $this->vintage = $vintage;
    }

    /**
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param string $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return BottleType
     */
    public function getBottleType()
    {
        return $this->bottleType;
    }

    /**
     * @param BottleType $bottleType
     */
    public function setBottleType($bottleType)
    {
        $this->bottleType = $bottleType;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Bottle
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Bottle
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
