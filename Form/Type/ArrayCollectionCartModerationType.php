<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrayCollectionCartModerationType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'data_class' => 'Esolving\ShopcartBundle\Entity\ArrayCollectionCart'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('cart','hidden')
        ;
    }

    public function getName() {
        return 'esolving_shopcartB_Shop_cart';
    }

}