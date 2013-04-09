<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Esolving\ShopcartBundle\Entity\SettingLanguage
 *
 * @ORM\Table(name="settings_languages")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\SettingLanguageRepository")
 */
class SettingLanguage
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
     * @ORM\Column(name="language", type="string", length=5, nullable=true)
     */
    private $language;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Setting", inversedBy="languages")
     */
    private $setting;
    
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
     * Set language
     *
     * @param string $language
     * @return SettingLanguage
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
     * Set description
     *
     * @param string $description
     * @return SettingLanguage
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
     * Set setting
     *
     * @param Esolving\ShopcartBundle\Entity\Setting $setting
     * @return SettingLanguage
     */
    public function setSetting(\Esolving\ShopcartBundle\Entity\Setting $setting = null)
    {
        $this->setting = $setting;
    
        return $this;
    }

    /**
     * Get setting
     *
     * @return Esolving\ShopcartBundle\Entity\Setting 
     */
    public function getSetting()
    {
        return $this->setting;
    }
}