<?php

namespace Esolving\ShopcartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Esolving\ShopcartBundle\Entity\User,
    Esolving\ShopcartBundle\Entity\Role;

class LoadUserRoleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $manager;
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        $roles = array(
            'ROLE_ADMIN' => array(
                'role_type_id' => 'role_ROLE_ADMIN',
                'status' => '1'
            ),
            'ROLE_USER' => array(
                'role_type_id' => 'role_ROLE_USER',
                'status' => '1'
            ),
            'ROLE_TREASURY' => array(
                'role_type_id' => 'role_ROLE_TREASURY',
                'status' => '1'
            ),
            'ROLE_SYSTEM' => array(
                'role_type_id' => 'role_ROLE_SYSTEM',
                'status' => '1'
            )
        );

        foreach ($roles as $roleK => $roleV) {
                $role = new Role();
                $role->setRoleType($manager->merge($this->getReference($roleV['role_type_id'])));
                $role->setStatus($roleV['status']);
                $manager->persist($role);
                $this->addReference($roleK, $role);
        }
        $manager->flush();

        $users = array(
            'luis' => array(
                'sex' => 'sex_man',
                'groupblod' => 'groupblod_o+',
                'distrit' => 'distrit_lince',
                'name' => 'Luis alberto',
                'lastname' => 'sanchez saldaña',
                'dateborn' => new \DateTime('1989-09-22'),
                'phone' => '3360524',
                'phonemovil' => '992192162',
                'email' => 'luis22989@hotmail.com',
                'address' => 'Av. Morales duarez #2249',
                'code' => 'admin',
                'password' => 'admin',
                'status' => '1',
                'roles'=> array(
                    'ROLE_ADMIN'
                )
            ),
            'pepe' => array(
                'sex' => 'sex_man',
                'groupblod' => 'groupblod_o-',
                'distrit' => 'distrit_lince',
                'name' => 'Pepe',
                'lastname' => 'Quiroga Quinteros',
                'dateborn' => new \DateTime('1986-09-22'),
                'phone' => '3360512',
                'phonemovil' => '996792162',
                'email' => 'pepe@hotmail.com',
                'address' => 'Av. Arenales #2249',
                'code' => 'system',
                'password' => 'system',
                'status' => '1',
                'roles'=> array(
                    'ROLE_SYSTEM'
                )
            ),
            'juan' => array(
                'sex' => 'sex_man',
                'groupblod' => 'groupblod_o-',
                'distrit' => 'distrit_lince',
                'name' => 'Juan',
                'lastname' => 'Tenorio Frodo',
                'dateborn' => new \DateTime('1976-09-22'),
                'phone' => '3363232',
                'phonemovil' => '967682162',
                'email' => 'juan@hotmail.com',
                'address' => 'Av. Arenales #2249',
                'code' => 'treasury',
                'password' => 'treasury',
                'status' => '1',
                'roles'=> array(
                    'ROLE_TREASURY'
                )
            )
        );

        foreach ($users as $userK => $property) {
            $user = new User();
            foreach($property['roles'] as $role){
                $user->addRolesacces($manager->merge($this->getReference($role)));
            }
            $user->setSexType($manager->merge($this->getReference($property['sex'])));

            $user->setGroupblodType($manager->merge($this->getReference($property['groupblod'])));

            $user->setDistritType($manager->merge($this->getReference($property['distrit'])));

            $user->setName($property['name']);
            $user->setLastname($property['lastname']);
            $user->setDateborn($property['dateborn']);
            $user->setPhone($property['phone']);
            $user->setPhonemovil($property['phonemovil']);
            $user->setEmail($property['email']);
            $user->setAddress($property['address']);
            $user->setCode($property['code']);
            $user->setSalt(md5(uniqid()));

            $encoder = $this->container
                    ->get('security.encoder_factory')
                    ->getEncoder($user)
            ;
            $user->setPassword($encoder->encodePassword($property["password"], $user->getSalt()));
            $user->setStatus($property['status']);
            $manager->persist($user);
            $this->addReference($userK, $user);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
