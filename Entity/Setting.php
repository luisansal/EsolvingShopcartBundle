<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Esolving\ShopcartBundle\Entity\Setting
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\SettingRepository")
 */
class Setting {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var type 
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var integer $setting_type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     */
    private $setting_type;

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $value;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="SettingLanguage", mappedBy="setting", cascade={"all"}, orphanRemoval=true)
     */
    private $languages;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    public function __construct() {
        $this->status = true;
    }
    
    public function __toString() {
        return $this->getName();
    }

    /**
     * Add languages
     *
     * @param Esolving\Bundle\Eschool\TypeBundle\Entity\SettingLanguage $settingLanguages
     * @return Type
     */
    public function addLanguage(\Esolving\ShopcartBundle\Entity\SettingLanguage $settingLanguages) {
        $this->languages[] = $settingLanguages;
        $settingLanguages->setSetting($this);
        return $this;
    }

    /**
     * This generate a row to the languages
     *
     * @param Esolving\ShopcartBundle\Entity\Language $languages
     * @return Type
     */
    public function addLanguages(\Esolving\ShopcartBundle\Entity\SettingLanguage $settingLanguages) {
        $this->languages[] = $settingLanguages;
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
     * Set name
     *
     * @param string $name
     * @return Setting
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
     * Set value
     *
     * @param float $value
     * @return Setting
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Setting
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
     * Set setting_type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $settingType
     * @return Setting
     */
    public function setSettingType(\Esolving\ShopcartBundle\Entity\Type $settingType = null)
    {
        $this->setting_type = $settingType;
    
        return $this;
    }

    /**
     * Get setting_type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getSettingType()
    {
        return $this->setting_type;
    }

    /**
     * Remove languages
     *
     * @param Esolving\ShopcartBundle\Entity\SettingLanguage $languages
     */
    public function removeLanguage(\Esolving\ShopcartBundle\Entity\SettingLanguage $languages)
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