<?php

namespace Esolving\ShopcartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Esolving\ShopcartBundle\Entity\Category;
use Esolving\ShopcartBundle\Entity\CategoryLanguage;
use Esolving\ShopcartBundle\Entity\Service;
use Esolving\ShopcartBundle\Entity\ServiceLanguage;

class LoadServiceCategoryLanguageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    protected $manager;
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $this->manager = $manager;

        $categories = array(
            'turistic' => array(
                'languages' => array(
                    'es' => array(
                        'name' => 'Turístico',
                        'description' => 'Viaje para conocer lugares turisticos'
                    ),
                    'en' => array(
                        'name' => 'Turistic',
                        'description' => 'Travel to know turistics places'
                    )
                )
            ),
            'cultural' => array(
                'languages' => array(
                    'es' => array(
                        'name' => 'Cultural',
                        'description' => 'Viaje para conocer un poco mas de nuestra cultura peruana'
                    ),
                    'en' => array(
                        'name' => 'Cultural',
                        'description' => 'Travel to know a title more of our peruvian culture'
                    )
                )
            ),
            'gastronomic' => array(
                'languages' => array(
                    'es' => array(
                        'name' => 'Gastronómico',
                        'description' => 'Viaje para conocer un poco mas de nuestra comida criolla'
                    ),
                    'en' => array(
                        'name' => 'Gastronomic',
                        'description' => 'Travel to know a litle more of our traditional peruvian food'
                    )
                )
            ),
            'entertainment' => array(
                'languages' => array(
                    'es' => array(
                        'name' => 'Entretenimiento',
                        'description' => 'Viaje para ir con toda la familia de entretenimiento'
                    ),
                    'en' => array(
                        'name' => 'Entertainment',
                        'description' => 'Travel to go with all family join fun'
                    )
                )
            )
        );

        foreach ($categories as $categoryK => $categoryV) {
            $category = new Category();
            foreach ($categoryV['languages'] as $languageK => $languageV) {
                $categoryLanguage = new CategoryLanguage();
                $categoryLanguage->setLanguage($languageK);
                $categoryLanguage->setCategory($category);
                $categoryLanguage->setName($languageV['name']);
                $categoryLanguage->setDescription($languageV['description']);
                $manager->persist($categoryLanguage);
            }
            $manager->persist($category);
            $this->addReference($categoryK, $category);
        }
        $manager->flush();

        $services = array(
            'travel_canta_entertainment' => array(
                'categories' => 'entertainment',
                'languages' => array(
                    'es' => array(
                        'name' => 'viaje a canta inolvidable',
                        'description' => 'En este verano ven a divertirte en canta un lugar para relajarse, montar caballo, ir a centros recreacionales, no te lo pierdas.'
                    ),
                    'en' => array(
                        'name' => 'unforgettable Canta trip',
                        'description' => 'This summer see fun in singing a place to relax, ride horseback, go to recreation centers, do not miss it.'
                    )
                ),
                'price' => '100',
                'stock' => '220'
            ),
            'travel_lunahuana_entertainment' => array(
                'categories' => 'entertainment',
                'languages' => array(
                    'es' => array(
                        'name' => 'viaje a Lunahuana inolvidable',
                        'description' => 'En este verano ven a divertirte en canta un lugar para relajarse, montar caballo, ir a centros recreacionales, no te lo pierdas.'
                    ),
                    'en' => array(
                        'name' => 'unforgettable Lunahuana trip',
                        'description' => 'This summer see fun in singing a place to relax, ride horseback, go to recreation centers, do not miss it.'
                    )
                ),
                'price' => '100',
                'stock' => '130'
            ),
            'travel_chincha_gastronomic' => array(
                'categories' => 'gastronomic',
                'languages' => array(
                    'es' => array(
                        'name' => 'viaje a chincha',
                        'description' => 'Paquete de viaje a chincha donde se comen las exquicitas comidas chinchanas'
                    ),
                    'en' => array(
                        'name' => 'Chincha trip',
                        'description' => 'Package trip to Chincha where meals are eaten delicious Chincha\'s food',
                    )
                ),
                'price' => '50',
                'stock' => '30'
            ),
            'travel_arequipa_gastronomic' => array(
                'categories' => 'gastronomic',
                'languages' => array(
                    'es' => array(
                        'name' => 'viaje a arequipa',
                        'description' => 'Paquete de viaje a arequipa donde se comen las exquicitas comidas arequipeñas'
                    ),
                    'en' => array(
                        'name' => 'Arequipa trip',
                        'description' => 'Package trip to Arequipa where meals are eaten delicious Arequipa\'s foods',
                    )
                ),
                'price' => '120',
                'stock' => '52'
            ),
            'travel_machupicchu_turistic' => array(
                'categories' => 'turistic',
                'languages' => array(
                    'es' => array(
                        'name' => 'viaje a Macchu Picchu',
                        'description' => 'Paquete de viaje a Macchu Picchu para hacer un recorido inolvidable de las ruinas mas antiguas y bellas del perú'
                    ),
                    'en' => array(
                        'name' => 'Macchu Picchu trip',
                        'description' => 'Package trip to Machu Picchu for an unforgettable tour of the oldest and most beautiful ruins of Peru',
                    )
                ),
                'price' => '120',
                'stock' => '52'
            )
        );

        foreach ($services as $serviceK => $serviceV) {
            $service = new Service();
            $service->addCategorie($manager->merge($this->getReference($serviceV['categories'])));
            foreach ($serviceV['languages'] as $languageK => $languageV) {
                $serviceLanguage = new ServiceLanguage();
                $serviceLanguage->setName($languageV['name']);
                $serviceLanguage->setDescription($languageV['description']);
                $serviceLanguage->setLanguage($languageK);
                $serviceLanguage->setService($service);
                $manager->persist($serviceLanguage);
            }
            $service->setPrice($serviceV['price']);
            $service->setStock($serviceV['stock']);
            $manager->persist($service);
            $this->addReference($serviceK, $service);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
