<?php

namespace Esolving\ShopcartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Esolving\ShopcartBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\RoleRepository")
 */
class Role {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $role
     *
        * @ORM\OneToOne(targetEntity="Type")
     * @Assert\NotBlank()
     */
    private $role_type;

    /**
     * This is the status
     * @var type 
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status;

    /**
     * @var integer $users
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="rolesaccess")
     */
    private $users;

    public function __toString() {
        return $this->getRoleType()->getName();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->status = true;
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param boolean $status
     * @return Role
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
     * Set role_type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $roleType
     * @return Role
     */
    public function setRoleType(\Esolving\ShopcartBundle\Entity\Type $roleType = null)
    {
        $this->role_type = $roleType;
    
        return $this;
    }

    /**
     * Get role_type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getRoleType()
    {
        return $this->role_type;
    }

    /**
     * Add users
     *
     * @param Esolving\ShopcartBundle\Entity\User $users
     * @return Role
     */
    public function addUser(\Esolving\ShopcartBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param Esolving\ShopcartBundle\Entity\User $users
     */
    public function removeUser(\Esolving\ShopcartBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}