<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class CheckType extends AbstractType {

    private $container;
    private $em;

    public function __construct(Container $container, EntityManager $em) {
        $this->container = $container;
        $this->em = $em;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'csrf_protection' => false
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $categories = $this->em->getRepository('EsolvingShopcartBundle:Category')->findAllByLanguage($this->container->get('request')->getLocale());
        $category = array();
        foreach ($categories as $categoryV) {
            $languages = $categoryV->getLanguages();
            $category[$categoryV->getId()] = $languages[0]->getName();
        }
        $builder
                ->add('best_sellers', 'checkbox', array(
                    'required' => false,
                    'label' => 'best_sellers'
                ))
                ->add('date_start', 'date', array(
                    'required' => false,
                    'years' => range(2000, 2020),
                    'attr' => array('class' => 'do-span'),
                    'label' => 'date_start'
                        )
                )
                ->add('date_end', 'date', array(
                    'required' => false,
                    'years' => range(2000, 2020),
                    'attr' => array('class' => 'do-span'),
                    'label' => 'date_end'
                        )
                )
                ->add('category', 'choice', array(
                    'data_class' => 'Esolving\ShopcartBundle\Entity\Category',
                    'choices' => $category,
                    'required' => false,
                    'label' => 'category'
                ))
                ->add('bad_sellers', 'checkbox', array(
                    'required' => false,
                    'label' => 'bad_sellers'
                        )
                )
                ->add('just_date', 'date', array(
                    'required' => false,
                    'years' => range(2000, 2020),
                    'attr' => array('class' => 'do-span'),
                    'label' => 'just_date'
                        )
                )
                ->add('choice_date', 'choice', array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        '0' => '',
                        '1' => ''
                    ),
                ))
        ;
    }

    public function getName() {
        return 'esolving_shopcartB_Treasury_check';
    }

}