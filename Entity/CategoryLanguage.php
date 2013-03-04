<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Esolving\ShopcartBundle\Entity\CategoryLanguage
 *
 * @ORM\Table(name="categories_languages")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\CategoryLanguageRepository")
 */
class CategoryLanguage {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     *
     * @var type 
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     *
     * @var type 
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=250, unique=true)
     */
    private $slug;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="languages")
     */
    private $category;

    /**
     *
     * @var type 
     * @ORM\Column(name="language", type="string", length=5)
     */
    private $language;

    public function __construct() {
        $this->status = true;
    }

    public function __toString() {
        return $this->getDescription();
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
     * Set name
     *
     * @param string $name
     * @return CategoryLanguage
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
     * @return CategoryLanguage
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
     * Set slug
     *
     * @param string $slug
     * @return CategoryLanguage
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
     * Set language
     *
     * @param string $language
     * @return CategoryLanguage
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
     * Set category
     *
     * @param Esolving\ShopcartBundle\Entity\Category $category
     * @return CategoryLanguage
     */
    public function setCategory(\Esolving\ShopcartBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return Esolving\ShopcartBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}