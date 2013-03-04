<?php

namespace Esolving\ShopcartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Esolving\ShopcartBundle\Entity\Language,
    Esolving\ShopcartBundle\Entity\Type;

class LoadTypeLanguageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $manager;
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        $types = array(
            'category_category' => array(
                'category' => 'category',
                'name' => 'category',
                'languages' => array(
                    'en' => 'Category',
                    'es' => 'Categoría'
                )
            ),
            'sex_sex' => array(
                'category' => 'sex',
                'name' => 'sex',
                'languages' => array(
                    'en' => 'Sex',
                    'es' => 'Sexo'
                )
            ),
            'headquarter_headquarter' => array(
                'category' => 'headquarter',
                'name' => 'headquarter',
                'languages' => array(
                    'es' => 'Sede',
                    'en' => 'Headquarter'
                )
            ),
            'sex_man' => array(
                'category' => 'sex',
                'name' => 'man',
                'languages' => array(
                    'es' => 'Hombre',
                    'en' => 'Man'
                )
            ),
            'sex_woman' => array(
                'category' => 'sex',
                'name' => 'woman',
                'languages' => array(
                    'es' => 'Mujer',
                    'en' => 'Woman'
                )
            ),
            'groupblod_groupblod' => array(
                'category' => 'groupblod',
                'name' => 'groupblod',
                'languages' => array(
                    'es' => 'Grupo sanguíneo',
                    'en' => 'Group blod'
                )
            ),
            'groupblod_o+' => array(
                'category' => 'groupblod',
                'name' => 'o+',
                'languages' => array(
                    'es' => 'O+ - es',
                    'en' => 'O+ - en'
                )
            ),
            'groupblod_o-' => array(
                'category' => 'groupblod',
                'name' => 'o-',
                'languages' => array(
                    'es' => 'O- es',
                    'en' => 'O- en'
                )
            ),
            'headquarter_atte' => array(
                'category' => 'headquarter',
                'name' => 'atte',
                'languages' => array(
                    'es' => 'Atte - es',
                    'en' => 'Atte - en'
                )
            ),
            'headquarter_lamolina' => array(
                'category' => 'headquarter',
                'name' => 'lamolina',
                'languages' => array(
                    'es' => 'La molina - es',
                    'en' => 'La molina - en'
                )
            ),
            'distrit_distrit' => array(
                'category' => 'distrit',
                'name' => 'distrit',
                'languages' => array(
                    'es' => 'Distrito',
                    'en' => 'Distrit'
                )
            ),
            'distrit_lince' => array(
                'category' => 'distrit',
                'name' => 'lince',
                'languages' => array(
                    'es' => 'Lince - es',
                    'en' => 'Lince - en'
                )
            ),
            'distrit_villamaria' => array(
                'category' => 'distrit',
                'name' => 'villamaria',
                'languages' => array(
                    'es' => 'Villa maría del triunfo - es',
                    'en' => 'Villa maría del triunfo - en'
                )
            ),
            'section_section' => array(
                'category' => 'section',
                'name' => 'section',
                'languages' => array(
                    'es' => 'Sección',
                    'en' => 'Section'
                )
            ),
            'section_initial' => array(
                'category' => 'section',
                'name' => 'initial',
                'languages' => array(
                    'es' => 'Inicial',
                    'en' => 'Initial'
                )
            ),
            'section_primary' => array(
                'category' => 'section',
                'name' => 'primary',
                'languages' => array(
                    'es' => 'Primaria',
                    'en' => 'Primary'
                )
            ),
            'section_secundary' => array(
                'category' => 'section',
                'name' => 'secundary',
                'languages' => array(
                    'es' => 'Secundaria',
                    'en' => 'Secundary'
                )
            ),
            'role_role' => array(
                'category' => 'role',
                'name' => 'role',
                'languages' => array(
                    'es' => 'Rol',
                    'en' => 'Role'
                )
            ),
            'role_ROLE_ADMIN' => array(
                'category' => 'role',
                'name' => 'ROLE_ADMIN',
                'languages' => array(
                    'es' => 'Rol Administrador',
                    'en' => 'Role Admin'
                )
            ),
            'role_ROLE_USER' => array(
                'category' => 'role',
                'name' => 'ROLE_USER',
                'languages' => array(
                    'es' => 'Rol Usuario',
                    'en' => 'Role User'
                )
            ),
            'role_ROLE_TREASURY' => array(
                'category' => 'role',
                'name' => 'ROLE_TREASURY',
                'languages' => array(
                    'es' => 'Rol Tesorería',
                    'en' => 'Role Treasury'
                )
            ),
            'role_ROLE_SYSTEM' => array(
                'category' => 'role',
                'name' => 'ROLE_SYSTEM',
                'languages' => array(
                    'es' => 'Rol Sistema',
                    'en' => 'Role System'
                )
            ),
            'setting_setting' => array(
                'category' => 'setting',
                'name' => 'setting',
                'languages' => array(
                    'es' => 'Configuración',
                    'en' => 'Setting'
                )
            ),
            'setting_gvi' => array(
                'category' => 'setting',
                'name' => 'setting_gvi',
                'languages' => array(
                    'es' => 'IGV',
                    'en' => 'IGV'
                )
            ),
            'setting_dolars_to_soles' => array(
                'category' => 'setting',
                'name' => 'setting_dolars_to_soles',
                'languages' => array(
                    'es' => 'Tipo de cambio: Dolares a soles',
                    'en' => 'Type change: Dolars to soles'
                )
            ),
            'setting_euros_to_soles' => array(
                'category' => 'setting',
                'name' => 'setting_euros_to_soles',
                'languages' => array(
                    'es' => 'Tipo de cambio: Euros a soles',
                    'en' => 'Type change: Euros to soles'
                )
            ),
            'setting_business_cart' => array(
                'category' => 'setting',
                'name' => 'setting_business_cart',
                'languages' => array(
                    'es' => 'Tarjeta de crédito',
                    'en' => 'Credit cart'
                )
            ),
            'setting_link_paypal_image'=> array(
                'category' => 'setting',
                'name' => 'setting_link_paypal_image',
                'languages' => array(
                    'es' => 'Imagen de Paypal',
                    'en' => 'Paypal image'
                )
            ),
            'money_money' => array(
                'category' => 'money',
                'name' => 'money',
                'languages' => array(
                    'es' => 'Tipo de dinero',
                    'en' => 'Type of cash'
                )
            ),
            'money_soles' => array(
                'category' => 'money',
                'name' => 'soles',
                'languages' => array(
                    'es' => 's/',
                    'en' => 's/'
                )
            ),
            'money_dolars' => array(
                'category' => 'money',
                'name' => 'dolars',
                'languages' => array(
                    'es' => 'Dinero en dolares',
                    'en' => 'Money dolars'
                )
            ),
            'money_euros' => array(
                'category' => 'money',
                'name' => 'euros',
                'languages' => array(
                    'es' => 'Dinero en euros',
                    'en' => 'Money in euros'
                )
            )
        );

        foreach ($types as $typeK => $typeV) {
            $type = new Type();
            $type->setCategory($typeV['category']);
            $type->setName($typeV['name']);
            foreach ($typeV['languages'] as $languageK => $languageV) {
                $language = new Language();
                $language->setLanguage($languageK);
                $language->setDescription($languageV);
                $language->setType($type);
                $manager->persist($language);
            }
            $manager->persist($type);
            $this->addReference($typeK, $type);
        }

        $manager->flush();

//        for ($i = 0; $i < 10000; $i++) {
//            $rand = rand(0, 100000);
//            $type = new Type();
//            $type->setCategory($rand);
//            $type->setName($rand);
//            for ($j = 0; $j < 2; $j++) {
//                switch ($j) {
//                    case 0:
//                        $languageInput = 'es';
//                        break;
//                    case 1:
//                        $languageInput = 'en';
//                        break;
//                }
//                $language = new Language();
//                $language->setLanguage($languageInput);
//                $language->setDescription($rand . ' - ' . $languageInput);
//                $language->setType($type);
//                $manager->persist($language);
//            }
//            $manager->persist($type);
////            $this->addReference($rand, $type);
//        }
//        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}
