<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Esolving\ShopcartBundle\Entity\Service
 *
 * @ORM\Table(name="services")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\ServiceRepository")
 */
class Service {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var \DateTime $dateregistered
     *
     * @ORM\Column(name="dateregistered", type="datetime")
     */
    private $dateregistered;

    /**
     * @var \DateTime $datemodificated
     *
     * @ORM\Column(name="datemodificated", type="datetime", nullable=true)
     */
    private $datemodificated;

    /**
     * @var \DateTime $datedisabled
     *
     * @ORM\Column(name="datedisabled", type="datetime", nullable=true)
     */
    private $datedisabled;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var integer $categories
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="services");
     * @ORM\JoinTable(name="services_categories",
     *  joinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     * @Assert\NotBlank()
     * @Assert\Count(
     *      min = "1"
     * )
     */
    private $categories;
    
//    /**
//     *
//     * @var type 
//     * @ORM\ManyToMany(targetEntity="User", mappedBy="services")
//     */
//    private $users;
    
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="ServiceLanguage", mappedBy="service", cascade={"all"}, orphanRemoval=true)
     */
    private $languages;
    
    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    public $image;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->status = true;
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateregistered = new \DateTime();
    }

    public function __toString() {
        $values = $this->getLanguages()->getValues();
        return $values[0]->getName();
    }
    
    /**
     * This generate a row to the languages
     *
     * @param Esolving\ShopcartBundle\Entity\ServiceLanguage $languages
     * @return Type
     */
    public function addLanguages(\Esolving\ShopcartBundle\Entity\ServiceLanguage $serviceLanguages) {
        $this->languages[] = $serviceLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Esolving\ShopcartBundle\Entity\CategoryLanguage $languages
     * @return Category
     */
    public function addLanguage(\Esolving\ShopcartBundle\Entity\ServiceLanguage $serviceLanguages) {
        $this->languages[] = $serviceLanguages;
        $serviceLanguages->setService($this);
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Service
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Service
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    
        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set dateregistered
     *
     * @param \DateTime $dateregistered
     * @return Service
     */
    public function setDateregistered($dateregistered)
    {
        $this->dateregistered = $dateregistered;
    
        return $this;
    }

    /**
     * Get dateregistered
     *
     * @return \DateTime 
     */
    public function getDateregistered()
    {
        return $this->dateregistered;
    }

    /**
     * Set datemodificated
     *
     * @param \DateTime $datemodificated
     * @return Service
     */
    public function setDatemodificated($datemodificated)
    {
        $this->datemodificated = $datemodificated;
    
        return $this;
    }

    /**
     * Get datemodificated
     *
     * @return \DateTime 
     */
    public function getDatemodificated()
    {
        return $this->datemodificated;
    }

    /**
     * Set datedisabled
     *
     * @param \DateTime $datedisabled
     * @return Service
     */
    public function setDatedisabled($datedisabled)
    {
        $this->datedisabled = $datedisabled;
    
        return $this;
    }

    /**
     * Get datedisabled
     *
     * @return \DateTime 
     */
    public function getDatedisabled()
    {
        return $this->datedisabled;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Service
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add categories
     *
     * @param Esolving\ShopcartBundle\Entity\Category $categories
     * @return Service
     */
    public function addCategorie(\Esolving\ShopcartBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param Esolving\ShopcartBundle\Entity\Category $categories
     */
    public function removeCategorie(\Esolving\ShopcartBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Remove languages
     *
     * @param Esolving\ShopcartBundle\Entity\ServiceLanguage $languages
     */
    public function removeLanguage(\Esolving\ShopcartBundle\Entity\ServiceLanguage $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set image
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $image
     * @return Service
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }
}