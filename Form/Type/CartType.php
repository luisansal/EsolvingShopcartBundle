<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Esolving\ShopcartBundle\Form\Type\ItemType;

class CartType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'data_class' => 'Esolving\ShopcartBundle\Entity\Cart'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('items', 'collection', array(
                    'type' => new ItemType()
                        )
                )

        ;
    }

    public function getName() {
        return 'esolving_shopcartB_Shop_cart';
    }

}