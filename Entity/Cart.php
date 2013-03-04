<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Esolving\ShopcartBundle\Entity\Cart
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\CartRepository")
 */
class Cart {

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
     * @ORM\Column(name="totalItems", type="integer")
     */
    private $totalItems;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="totalPrice", type="decimal", scale=2)
     */
    private $totalPrice;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="carts")
     */
    private $user;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="Item", mappedBy="cart", cascade={"persist"})
     */
    private $items;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="success", type="boolean")
     */
    private $success;

    /**
     *
     * @var type 
     * @ORM\Column(name="datesuccess", type="datetime", nullable=true)
     */
    private $dateSuccess;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="expiredAt", type="datetime")
     */
    private $expiredAt;
    
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="CartModeration", mappedBy="cart")
     */
    private $moderations;
    
    public function __construct() {
        $this->expiredAt = new \DateTime('+1day');
        $this->success = false;
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moderations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->totalItems = 0;
        $this->dateregistered = new \DateTime();
        $this->status = true;
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
     * @return Cart
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
     * @return Cart
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
     * @return Cart
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
     * @return Cart
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
     * Set totalItems
     *
     * @param integer $totalItems
     * @return Cart
     */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    
        return $this;
    }

    /**
     * Get totalItems
     *
     * @return integer 
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     * @return Cart
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    
        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set success
     *
     * @param boolean $success
     * @return Cart
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
     * @return Cart
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
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     * @return Cart
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;
    
        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime 
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set user
     *
     * @param Esolving\ShopcartBundle\Entity\User $user
     * @return Cart
     */
    public function setUser(\Esolving\ShopcartBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Esolving\ShopcartBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add items
     *
     * @param Esolving\ShopcartBundle\Entity\Item $items
     * @return Cart
     */
    public function addItem(\Esolving\ShopcartBundle\Entity\Item $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param Esolving\ShopcartBundle\Entity\Item $items
     */
    public function removeItem(\Esolving\ShopcartBundle\Entity\Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add moderations
     *
     * @param Esolving\ShopcartBundle\Entity\CartModeration $moderations
     * @return Cart
     */
    public function addModeration(\Esolving\ShopcartBundle\Entity\CartModeration $moderations)
    {
        $this->moderations[] = $moderations;
    
        return $this;
    }

    /**
     * Remove moderations
     *
     * @param Esolving\ShopcartBundle\Entity\CartModeration $moderations
     */
    public function removeModeration(\Esolving\ShopcartBundle\Entity\CartModeration $moderations)
    {
        $this->moderations->removeElement($moderations);
    }

    /**
     * Get moderations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getModerations()
    {
        return $this->moderations;
    }
}