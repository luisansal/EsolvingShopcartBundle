<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Esolving\Bundle\Eschool\TypeBundle\Entity\Language
 *
 * @ORM\Table(name="languages")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\LanguageRepository")
 */
class Language {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * This field must be primary key too but sonata admin bundle not support this by now... 25/08/2012 ORM\Id
     * @var integer $type   
     * 
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="languages")
     */
    protected $type;

    /**
     * @var string $descrption
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * This field must be primary key but type not is primary key both must be primary ey but sonata not permit multiples key 25/08/2012 ORM\Id
     * @var string $language
     *
     * @ORM\Column(name="language", type="string", length=5)
     */
    protected $language;

    public function __toString() {
        return $this->getDescription();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Language
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Language
     */
    public function setLanguage($language) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Set type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $type
     * @return Language
     */
    public function setType(\Esolving\ShopcartBundle\Entity\Type $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getType() {
        return $this->type;
    }

}