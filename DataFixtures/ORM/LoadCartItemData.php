<?php

namespace Esolving\ShopcartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Esolving\ShopcartBundle\Entity\Cart;
use Esolving\ShopcartBundle\Entity\Item;

class LoadCartItemData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $manager;
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        
        $carts = array(
            'cart_luis'=> array(
                'user' =>'luis'
            ),
            'cart_pepe'=> array(
                'user' =>'pepe'
            )
        );
        
        foreach($carts as $cartK => $cartV){
            $cart = new Cart();
            $cart->setUser($manager->merge($this->getReference($cartV['user'])));
            $cart->setTotalItems('0');
            $cart->setTotalPrice('0');
            $manager->persist($cart);
            $this->addReference($cartK, $cart);
        }
        $manager->flush();
        
        $items = array(
            'item_luis_1' => array(
                'cart'=> 'cart_luis',
                'service' => 'travel_canta_entertainment',
                'quantity'=>'2'
            ),
            'item_luis_2' => array(
                'cart'=> 'cart_luis',
                'service' => 'travel_machupicchu_turistic',
                'quantity'=>'3'
            ),
            'item_pepe_1' => array(
                'cart'=> 'cart_pepe',
                'service' => 'travel_chincha_gastronomic',
                'quantity'=>'3'
            ),
            'item_pepe_2' => array(
                'cart'=> 'cart_pepe',
                'service' => 'travel_arequipa_gastronomic',
                'quantity'=>'5'
            )
        );
        
        foreach($items as $itemK => $itemV){
            $item = new Item();
            $item->setCart($manager->merge($this->getReference($itemV['cart'])));
            $item->setService($manager->merge($this->getReference($itemV['service'])));
            $item->setQuantity($itemV['quantity']);
            $manager->persist($item);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }

}
