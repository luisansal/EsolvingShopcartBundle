<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CartBuyMethodType extends AbstractType {
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'data_class' => 'Esolving\ShopcartBundle\Entity\Cart'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('method', 'choice', array(
                    'choices' => array(
                        '0' => 'paypal', '1' => 'transfer'
                    ),
                    'expanded'=>true,
                        )
                )

        ;
    }

    public function getName() {
        return 'esolving_shopcartB_Shop_cart_method';
    }

}