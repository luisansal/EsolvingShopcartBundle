<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Esolving\ShopcartBundle\Entity\Item
 *
 * @ORM\Table(name="items")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\ItemRepository")
 */
class Item {

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
     *
     * @var type 
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     */
    private $cart;

    /**
     *
     * @var type 
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\Blank()
     * 
     */
    private $quantity;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Service")
     */
    private $service;

    public function __construct() {
        $this->dateregistered = new \DateTime();
        $this->status = true;
        $this->quantity++;
    }
    
    public function addQuantity(){
        return $this->quantity++;
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
     * Set dateregistered
     *
     * @param \DateTime $dateregistered
     * @return Item
     */
    public function setDateregistered($dateregistered) {
        $this->dateregistered = $dateregistered;

        return $this;
    }

    /**
     * Get dateregistered
     *
     * @return \DateTime 
     */
    public function getDateregistered() {
        return $this->dateregistered;
    }

    /**
     * Set datemodificated
     *
     * @param \DateTime $datemodificated
     * @return Item
     */
    public function setDatemodificated($datemodificated) {
        $this->datemodificated = $datemodificated;

        return $this;
    }

    /**
     * Get datemodificated
     *
     * @return \DateTime 
     */
    public function getDatemodificated() {
        return $this->datemodificated;
    }

    /**
     * Set datedisabled
     *
     * @param \DateTime $datedisabled
     * @return Item
     */
    public function setDatedisabled($datedisabled) {
        $this->datedisabled = $datedisabled;

        return $this;
    }

    /**
     * Get datedisabled
     *
     * @return \DateTime 
     */
    public function getDatedisabled() {
        return $this->datedisabled;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Item
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Item
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set cart
     *
     * @param Esolving\ShopcartBundle\Entity\Cart $cart
     * @return Item
     */
    public function setCart(\Esolving\ShopcartBundle\Entity\Cart $cart = null) {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return Esolving\ShopcartBundle\Entity\Cart 
     */
    public function getCart() {
        return $this->cart;
    }

    /**
     * Set service
     *
     * @param Esolving\ShopcartBundle\Entity\Service $service
     * @return Item
     */
    public function setService(\Esolving\ShopcartBundle\Entity\Service $service = null) {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return Esolving\ShopcartBundle\Entity\Service 
     */
    public function getService() {
        return $this->service;
    }

}