<?php

namespace Esolving\ShopcartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Esolving\ShopcartBundle\Entity\Setting;
use Esolving\ShopcartBundle\Entity\SettingLanguage;

class LoadSettingData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $manager;
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        $settings = array(
            'gvi' => array(
                'name' => 'gvi',
                'value' => '0.18',
                'setting_type' => 'setting_gvi',
            ),
            'dolars_to_soles' => array(
                'name' => 'dolars_to_soles',
                'value' => '2.73',
                'setting_type' => 'setting_dolars_to_soles',
            ),
            'euros_to_soles' => array(
                'name' => 'euros_to_soles',
                'value' => '3.25',
                'setting_type' => 'setting_euros_to_soles',
            ),
            'default_money' => array(
                'name' => 'default_money',
                'setting_type' => 'money_dolars',
                'languages' => array(
                    'es' => 's/',
                    'en' => 's/'
                )
            ),
            'money_dolars' => array(
                'name' => 'money_dolars',
                'setting_type' => 'money_dolars',
                'languages' => array(
                    'es' => '$',
                    'en' => '$'
                )
            ),
            'money_soles' => array(
                'name' => 'money_soles',
                'setting_type' => 'money_soles',
                'languages' => array(
                    'es' => 's/',
                    'en' => 's/'
                )
            ),
            'business_cart' => array(
                'name' => 'business_cart',
                'setting_type' => 'setting_business_cart',
                'languages' => array(
                    'es' => '191-22000519-0-46',
                    'en' => '191-22000519-0-46'
                )
            ),
            'link_paypal_image' => array(
                'name' => 'link_paypal_image',
                'setting_type' => 'setting_link_paypal_image',
                'languages' => array(
                    'es' => 'https://www.paypalobjects.com/es_XC/i/btn/btn_buynowCC_LG.gif',
                    'en' => 'https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif'
                )
            ),
        );

        foreach ($settings as $settingV) {
            $setting = new Setting();
            $setting->setName($settingV['name']);
            $setting->setSettingType($manager->merge($this->getReference($settingV['setting_type'])));
            if (isset($settingV['value'])) {
                $setting->setValue($settingV['value']);
            }
            if (isset($settingV['languages'])) {
                foreach ($settingV['languages'] as $languageK => $languageV) {
                    $language = new SettingLanguage();
                    $language->setSetting($setting);
                    $language->setLanguage($languageK);
                    $language->setDescription($languageV);
                    $manager->persist($language);
                }
            }
            $manager->persist($setting);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
