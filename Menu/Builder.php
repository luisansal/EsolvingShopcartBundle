<?php

namespace Esolving\ShopcartBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function guestMenu(FactoryInterface $factory, array $options) {
        $request = $this->container->get('request');

        $menu = $factory->createItem('menu_guest');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('home', array(
            'route' => 'esolving_shopcartB_index')
        );
        $menu->addChild('services', array(
            'route' => 'esolving_shopcartB_services',
//                    'routeParameters' => array('id' => 42)
        ));
        $menu->addChild('contact_us', array('route' => 'esolving_shopcartB_contact'));
        $menu->addChild('news', array('route' => 'esolving_shopcartB_news'));
        $menu->addChild('shop', array('route' => 'esolving_shopcartB_Shop_shop_news'));

        if ($this->container->get('security.context')->isGranted('ROLE_USER')) {
            $child = $menu->addChild('my_account')->setExtra('html', '<span class="arrow"></span>');
            $child->addChild('profile', array(
                'route' => 'esolving_shopcartB_User_profile')
            );
            $child->addChild('log_out', array(
                'route' => 'logout',
                'routeParameters' => array(
                    "_locale" => $request->getLocale()
                )
            ));
        } else {
            $menu->addChild('log_in', array(
                'route' => 'esolving_shopcartB_login'
            ));
            $menu->addChild('register', array(
                'route' => 'esolving_shopcartB_User_create_only_user'
            ));
        }

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options) {
        $request = $this->container->get('request');

        $menu = $factory->createItem('menu_user');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('home', array(
            'route' => 'esolving_shopcartB_User_index')
        );
        $menu->addChild('shop', array(
            'route' => 'esolving_shopcartB_Shop_shop_news',
        ));


        $childMyAccount = $menu->addChild('my_account')->setExtra('html', '<span class="arrow"></span>');
        $childMyAccount->addChild('profile', array(
            'route' => 'esolving_shopcartB_User_profile')
        );
        $childMyAccount->addChild('log_out', array(
            'route' => 'logout',
            'routeParameters' => array(
                "_locale" => $request->getLocale()
            )
        ));

        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('ROLE_SYSTEM')) {

            $childUser = $menu->addChild('users')->setExtra('html', '<span class="arrow"></span>');
            $childUser->addChild('register_user', array(
                'route' => 'esolving_shopcartB_User_register'
            ));
            $childUser->addChild('show_users', array(
                'route' => 'esolving_shopcartB_User_show'
            ));
        }

        if ($securityContext->isGranted('ROLE_ADMIN')) {

            $menu->addChild('administration', array(
                'route' => 'sonata_admin_dashboard'
            ));
        }

        if ($securityContext->isGranted('ROLE_SYSTEM') || $securityContext->isGranted('ROLE_ADMIN')) {

            $menu->addChild('moderation', array(
                'route' => 'esolving_shopcartB_Shop_no_moderates'
            ));
        }

        if ($securityContext->isGranted('ROLE_TREASURY') || $securityContext->isGranted('ROLE_SYSTEM') || $securityContext->isGranted('ROLE_ADMIN')) {
            $menu->addChild('data_mining_sellers', array(
                'route' => 'esolving_shopcartB_DataMiningSeller_check'
            ));
        }

        return $menu;
    }

}