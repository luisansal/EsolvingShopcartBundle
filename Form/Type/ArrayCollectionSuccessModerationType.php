<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrayCollectionSuccessModerationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('success','checkbox');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Esolving\ShopcartBundle\Entity\ArrayCollectionSuccess'
        ));
    }

    public function getName() {
        return 'esolving_shopcartbundle_successmoderationtype';
    }

}
