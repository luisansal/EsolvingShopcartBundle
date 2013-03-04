<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Esolving\ShopcartBundle\Entity\Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\CategoryRepository")
 */
class Category {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="CategoryLanguage", mappedBy="category", cascade={"all"}, orphanRemoval=true)
     */
    private $languages;

    /**
     *
     * @var type 
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="categories")
     */
    private $services;

    public function __construct() {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = true;
        $this->dateregistered = new \Datetime();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * This generate a row to the languages
     *
     * @param Esolving\ShopcartBundle\Entity\CategoryLanguage $languages
     * @return Type
     */
    public function addLanguages(\Esolving\ShopcartBundle\Entity\CategoryLanguage $categoryLanguages) {
        $this->languages[] = $categoryLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Esolving\ShopcartBundle\Entity\CategoryLanguage $languages
     * @return Category
     */
    public function addLanguage(\Esolving\ShopcartBundle\Entity\CategoryLanguage $categoryLanguages) {
        $this->languages[] = $categoryLanguages;
        $categoryLanguages->setCategory($this);
        return $this;
    }
    
    public function __toString() {
        $values = $this->getLanguages()->getValues();
        return $values[0]->getName();
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
     * Set dateregistered
     *
     * @param \DateTime $dateregistered
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * Remove languages
     *
     * @param Esolving\ShopcartBundle\Entity\CategoryLanguage $languages
     */
    public function removeLanguage(\Esolving\ShopcartBundle\Entity\CategoryLanguage $languages)
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
     * Add services
     *
     * @param Esolving\ShopcartBundle\Entity\Service $services
     * @return Category
     */
    public function addService(\Esolving\ShopcartBundle\Entity\Service $services)
    {
        $this->services[] = $services;
    
        return $this;
    }

    /**
     * Remove services
     *
     * @param Esolving\ShopcartBundle\Entity\Service $services
     */
    public function removeService(\Esolving\ShopcartBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }
}