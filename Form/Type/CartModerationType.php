<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Esolving\ShopcartBundle\Form\Type\ArrayCollectionSuccessModerationType;
//use Esolving\ShopcartBundle\Form\Type\ArrayCollectionCartModerationType;

class CartModerationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('carts','collection',array(
            'type'=> new ArrayCollectionCartModerationType()
        ))
        ->add('success','collection',array(
            'type' => new ArrayCollectionSuccessModerationType()
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Esolving\ShopcartBundle\Entity\CartModeration'
        ));
    }

    public function getName() {
        return 'esolving_shopcartbundle_cartmoderationtype';
    }

}
