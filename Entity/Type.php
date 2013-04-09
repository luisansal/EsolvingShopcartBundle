<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Esolving\Bundle\Eschool\TypeBundle\Entity\Type
 *
 * @ORM\Table(name="types", uniqueConstraints={@ORM\UniqueConstraint(name="uniques", columns={"name", "category"})})
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\TypeRepository")
 */
class Type {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $category
     *
     * @ORM\Column(name="category", type="string", length=45)
     */
    protected $category;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    protected $name;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="boolean", length=1, nullable=true)
     */
    protected $status;

    /**
     * @var integer $languages
     *
     * @ORM\OneToMany(targetEntity="Language", mappedBy="type", cascade={"all"}, orphanRemoval=true);
     */
    protected $languages;

    /**
     * Add languages
     *
     * @param Esolving\Bundle\Eschool\TypeBundle\Entity\Language $languages
     * @return Type
     */
    public function addLanguage(\Esolving\ShopcartBundle\Entity\Language $languages) {
        $this->languages[] = $languages;
        $languages->setType($this);
        return $this;
    }

    public function __toString() {
        return $this->getName();
    }

    public function __construct() {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = true;
    }

    /**
     * This generate a row to the languages
     *
     * @param Esolving\ShopcartBundle\Entity\Language $languages
     * @return Type
     */
    public function addLanguages(\Esolving\ShopcartBundle\Entity\Language $languages) {
        $this->languages[] = $languages;
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
     * Set category
     *
     * @param string $category
     * @return Type
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Type
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
     * Set status
     *
     * @param boolean $status
     * @return Type
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
     * @param Esolving\ShopcartBundle\Entity\Language $languages
     */
    public function removeLanguage(\Esolving\ShopcartBundle\Entity\Language $languages)
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
}