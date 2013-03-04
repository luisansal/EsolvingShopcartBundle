<?php

namespace Esolving\ShopcartBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM; 

/**
 * Esolving\ShopcartBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Esolving\ShopcartBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User implements EquatableInterface, UserInterface {

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
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=45)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var date $dateborn
     *
     * @ORM\Column(name="dateborn", type="date")
     * @Assert\NotBlank()
     */
    private $dateborn;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=15)
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @var string $phonemovil
     *
     * @ORM\Column(name="phonemovil", type="string", length=15, nullable=true)
     */
    private $phonemovil;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\MinLength(limit=10, message="min_length")
     * @Assert\NotBlank()
     * @Assert\Email(message = "invalid_email")
     */
    protected $email;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=250)
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var string $code
     *
     * @ORM\Column(name="code", type="string", length=30)
     */
    private $code;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=300)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var datetime $dateregistered
     *
     * @ORM\Column(name="dateregistered", type="datetime")
     */
    private $dateregistered;

    /**
     * @var datetime $datemodificated
     *
     * @ORM\Column(name="datemodificated", type="datetime", nullable=true)
     */
    private $datemodificated;

    /**
     * @var datetime $datedisabled
     *
     * @ORM\Column(name="datedisabled", type="datetime", nullable=true)
     */
    private $datedisabled;

    /**
     * @var integer $sex_type
     * 
     * @ORM\ManyToOne(targetEntity="Type")
     */
    private $sex_type;

    /**
     * @var integer $distrit_type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     */
    private $distrit_type;

    /**
     * @var integer $groupblod_type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     */
    private $groupblod_type;

    /**
     *
     * @var type 
     * @ORM\Column(name="rand", type="string", length=2, nullable=true)
     */
    private $rand;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="boolean", length=1)
     */
    private $status;

    /**
     * @var integer $roles
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users");
     * @ORM\JoinTable(name="users_roles",
     *  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     * @Assert\NotBlank()
     * @Assert\Count(
     *      min = "1",
     *      max = "5"
     * )
     */
    private $rolesaccess;

//    /**
//     * @var integer $services
//     *
//     * @ORM\ManyToMany(targetEntity="Service", inversedBy="users");
//     * @ORM\JoinTable(name="users_services",
//     *  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
//     *  inverseJoinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")}
//     * )
//     * @Assert\Count(
//     *      min = "1",
//     *      max = "5"
//     * )
//     */
//    private $services;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="Cart", mappedBy="user")
     */
    private $carts;

//    /**
//     *
//     * @var type 
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $path;
//
//    /**
//     * @Assert\File(maxSize="6000000")
//     */
//    public $file;
    
    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    public $image;

    /**
     * @ORM\PreUpdate()
     */
    public function postDateModificated() {
        $this->datemodificated = new \DateTime();
    }

//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function preUpload() {
//        if (null !== $this->file) {
//            // do whatever you want to generate a unique name
//            $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
//        }
//    }

//    /**
//     * @ORM\PostPersist()
//     * @ORM\PostUpdate()
//     */
//    public function upload() {
//        if (null === $this->file) {
//            return;
//        }
//
//        // if there is an error when moving the file, an exception will
//        // be automatically thrown by move(). This will properly prevent
//        // the entity from being persisted to the database on error
//        $this->file->move($this->getUploadRootDir(), $this->path);
//
//        unset($this->file);
//    }

//    /**
//     * @ORM\PostRemove()
//     */
//    public function removeUpload() {
//        if ($file = $this->getAbsolutePath()) {
//            unlink($file);
//        }
//    }

//    public function upload() {
//        // the file property can be empty if the field is not required
//        if (null === $this->file) {
//            return;
//        }
//
//        // we use the original file name here but you should
//        // sanitize it at least to avoid any security issues
//        // move takes the target directory and then the target filename to move to
//        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
//
//        // set the path property to the filename where you'ved saved the file
//        $this->path = $this->file->getClientOriginalName();
//
//        // clean up the file property as you won't need it anymore
//        $this->file = null;
//    }

//    public function getAbsolutePath() {
//        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
//    }
//
//    public function getWebPath() {
//        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
//    }
//
//    protected function getUploadRootDir() {
//        // the absolute directory path where uploaded documents should be saved
//        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
//    }
//
//    protected function getUploadDir() {
//        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
//        return 'uploads/user-files';
//    }

    public function __construct() {
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rolesaccess = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateregistered = new \DateTime();
        $this->salt = md5(uniqid(null, true));
        $this->password = "default";
        $this->code = "default";
        $this->status = true;
    }

    public function __toString() {
        return $this->getName() . ' ' . $this->getLastname();
    }

    /**
     * 
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return type
     */
    function isEqualTo(UserInterface $user) {
        return $this->getCode() == $user->getCode();
    }

    function eraseCredentials() {
        
    }

    function getRoles() {
//        return array('ROLE_USER','IS_AUTHENTICATED','ROLE_ADMIN');
        $array = array();
        foreach ($this->getRolesaccess() as $role) {
            $array[] = $role->getRoleType()->getName();
        }
        return $array;
    }

    function getUsername() {
        return $this->getCode();
    }

    public function getAge() {
        $date = new \DateTime();
        return $date->format('Y') - $this->getDateborn()->format('Y');
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt() {
        return $this->salt;
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
     * @return User
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
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set dateborn
     *
     * @param \DateTime $dateborn
     * @return User
     */
    public function setDateborn($dateborn)
    {
        $this->dateborn = $dateborn;
    
        return $this;
    }

    /**
     * Get dateborn
     *
     * @return \DateTime 
     */
    public function getDateborn()
    {
        return $this->dateborn;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phonemovil
     *
     * @param string $phonemovil
     * @return User
     */
    public function setPhonemovil($phonemovil)
    {
        $this->phonemovil = $phonemovil;
    
        return $this;
    }

    /**
     * Get phonemovil
     *
     * @return string 
     */
    public function getPhonemovil()
    {
        return $this->phonemovil;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return User
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set dateregistered
     *
     * @param \DateTime $dateregistered
     * @return User
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
     * @return User
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
     * @return User
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
     * Set rand
     *
     * @param string $rand
     * @return User
     */
    public function setRand($rand)
    {
        $this->rand = $rand;
    
        return $this;
    }

    /**
     * Get rand
     *
     * @return string 
     */
    public function getRand()
    {
        return $this->rand;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
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
     * Set path
     *
     * @param string $path
     * @return User
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set sex_type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $sexType
     * @return User
     */
    public function setSexType(\Esolving\ShopcartBundle\Entity\Type $sexType = null)
    {
        $this->sex_type = $sexType;
    
        return $this;
    }

    /**
     * Get sex_type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getSexType()
    {
        return $this->sex_type;
    }

    /**
     * Set distrit_type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $distritType
     * @return User
     */
    public function setDistritType(\Esolving\ShopcartBundle\Entity\Type $distritType = null)
    {
        $this->distrit_type = $distritType;
    
        return $this;
    }

    /**
     * Get distrit_type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getDistritType()
    {
        return $this->distrit_type;
    }

    /**
     * Set groupblod_type
     *
     * @param Esolving\ShopcartBundle\Entity\Type $groupblodType
     * @return User
     */
    public function setGroupblodType(\Esolving\ShopcartBundle\Entity\Type $groupblodType = null)
    {
        $this->groupblod_type = $groupblodType;
    
        return $this;
    }

    /**
     * Get groupblod_type
     *
     * @return Esolving\ShopcartBundle\Entity\Type 
     */
    public function getGroupblodType()
    {
        return $this->groupblod_type;
    }

    /**
     * Add rolesaccess
     *
     * @param Esolving\ShopcartBundle\Entity\Role $rolesaccess
     * @return User
     */
    public function addRolesacces(\Esolving\ShopcartBundle\Entity\Role $rolesaccess)
    {
        $this->rolesaccess[] = $rolesaccess;
    
        return $this;
    }

    /**
     * Remove rolesaccess
     *
     * @param Esolving\ShopcartBundle\Entity\Role $rolesaccess
     */
    public function removeRolesacces(\Esolving\ShopcartBundle\Entity\Role $rolesaccess)
    {
        $this->rolesaccess->removeElement($rolesaccess);
    }

    /**
     * Get rolesaccess
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRolesaccess()
    {
        return $this->rolesaccess;
    }

    /**
     * Add carts
     *
     * @param Esolving\ShopcartBundle\Entity\Cart $carts
     * @return User
     */
    public function addCart(\Esolving\ShopcartBundle\Entity\Cart $carts)
    {
        $this->carts[] = $carts;
    
        return $this;
    }

    /**
     * Remove carts
     *
     * @param Esolving\ShopcartBundle\Entity\Cart $carts
     */
    public function removeCart(\Esolving\ShopcartBundle\Entity\Cart $carts)
    {
        $this->carts->removeElement($carts);
    }

    /**
     * Get carts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * Set image
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $image
     * @return User
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }
}