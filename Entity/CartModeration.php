<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Esolving\ShopcartBundle\Entity\CartModeration
 *
 * @ORM\Table(name="cart_moderations")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\CartModerationRepository")
 */
class CartModeration {

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
     * @var boolean $success
     *
     * @ORM\Column(name="success", type="boolean")
     */
    private $success;
    
    /**
     * @var datetime $success
     *
     * @ORM\Column(name="dateSuccess", type="datetime", nullable=true)
     */
    private $dateSuccess;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="paymentMethod", type="string", length=8)
     */
    private $paymentMethod;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="moderations");
     */
    private $cart;
    
    private $carts;

    public function __construct() {
        $this->dateregistered = new \DateTime();
        $this->status = true;
        $this->success = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getCarts(){
        return $this->carts;
    }
    
    public function setCarts($carts){
        $this->carts = $carts;
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
     * Set dateregistered
     *
     * @param \DateTime $dateregistered
     * @return CartModeration
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
     * @return CartModeration
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
     * @return CartModeration
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
     * @return CartModeration
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
     * Set success
     *
     * @param boolean $success
     * @return CartModeration
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    
        return $this;
    }

    /**
     * Get success
     *
     * @return boolean 
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set dateSuccess
     *
     * @param \DateTime $dateSuccess
     * @return CartModeration
     */
    public function setDateSuccess($dateSuccess)
    {
        $this->dateSuccess = $dateSuccess;
    
        return $this;
    }

    /**
     * Get dateSuccess
     *
     * @return \DateTime 
     */
    public function getDateSuccess()
    {
        return $this->dateSuccess;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return CartModeration
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    
        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set cart
     *
     * @param Esolving\ShopcartBundle\Entity\Cart $cart
     * @return CartModeration
     */
    public function setCart(\Esolving\ShopcartBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;
    
        return $this;
    }

    /**
     * Get cart
     *
     * @return Esolving\ShopcartBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }
}