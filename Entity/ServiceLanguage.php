<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Esolving\ShopcartBundle\Entity\ServiceLanguage
 *
 * @ORM\Table(name="services_languages")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\ServiceLanguageRepository")
 */
class ServiceLanguage
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $language
     *
     * @ORM\Column(name="language", type="string", length=5)
     */
    private $language;
    
    /**
     *
     * @var type 
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=250, unique=true)
     */
    private $slug;
    
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="languages")
     */
    private $service;
    
    public function __toString() {
        return $this->getName();
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
     * Set language
     *
     * @param string $language
     * @return ServiceLanguage
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return ServiceLanguage
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ServiceLanguage
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
     * @return ServiceLanguage
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
     * Set service
     *
     * @param Esolving\ShopcartBundle\Entity\Service $service
     * @return ServiceLanguage
     */
    public function setService(\Esolving\ShopcartBundle\Entity\Service $service = null)
    {
        $this->service = $service;
    
        return $this;
    }

    /**
     * Get service
     *
     * @return Esolving\ShopcartBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
}