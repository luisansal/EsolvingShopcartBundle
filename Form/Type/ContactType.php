<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $collectionConstraint = new Collection(array(
                    'name' => array(new NotBlank(), new MinLength(5)),
                    'email' => array(new Email(), new NotBlank()),
                    'subject' => new NotBlank(),
                    'message' => array()
                ));

        $resolver->setDefaults(array(
            'validation_constraint' => $collectionConstraint,
            'translation_domain' => 'EsolvingShopcartBundle'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array(
                    'label' => 'name',
                    'attr' => array(
                        'class' => 'some_class'
                    )
                ))
                ->add('email', 'email', array(
                    'label' => 'email',
                    'attr' => array(
//                        "oninvalid" => "setCustomValidity('Would you please enter a valid email?')"
                    )
                        )
                )
                ->add('subject', null, array('label' => 'subject'))
                ->add('message', 'textarea', array(
                    'label' => 'message'))
//                ->add('myDate', 'date', array(
//                    'years' => range(date('Y') - 10, date('Y') + 20)
//                ))
//                ->add('myDate', 'date', array(
//                    'widget' => 'single_text',
//                    'format' => 'dd-MM-yyyy',
//                    'attr' => array('class' => 'date')
//                ))

        ;
    }

    public function getName() {
        return 'esolving_shopcartB_contact';
    }

}