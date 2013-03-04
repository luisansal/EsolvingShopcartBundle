<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Esolving\ShopcartBundle\Validator\Constraints\EqualsFields;
use Esolving\ShopcartBundle\Validator\Constraints\IsActualPassword;
use Symfony\Component\DependencyInjection\Container;

class UserUpdateType extends AbstractType {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'data_class' => 'Esolving\ShopcartBundle\Entity\User'
        ));
    }

    public function getTypeByCategoryByLanguage($xcategory, $xlanguage) {
        return $getSex = $this
                ->container->get('doctrine')
                ->getRepository("EsolvingShopcartBundle:Type")
                ->findByCategoryByLanguage($xcategory, $xlanguage);
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('actualPassword', 'password', array(
                    'property_path' => false,
                    'validation_constraint' => array(new IsActualPassword(array('required' => false))),
                    'required' => false,
                    'label' => 'actual_password'
                        )
                )
//                ->add('newPassword', 'password', array(
//                    'property_path' => false,
//                    'required' => false,
//                    'label' => 'new_password'
//                        )
//                )
//                ->add('confirmationPassword', 'password', array(
//                    'validation_constraint' => array(new EqualsFields(array("field" => "newPassword", 'label' => 'new_password', 'required' => false))),
//                    'required' => false,
//                    'property_path' => false,
//                    'label' => 'confirmation_password'
//                        )
//                )
                ->add('passwordRepeated', 'repeated', array(
                    'property_path' => false,
                    'type' => 'password',
                    'invalid_message' => 'the_password_and_new_password_fields_must_be_match',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => false,
                    'second_options' => array('label' => 'confirmation_password'),
                    'first_options' => array('label' => 'new_password'),
                ))
                ->add('dateborn', null, array(
                    'label' => 'dateborn',
                    'years' => range(date('Y') - 60, date('Y') + 10)
                        )
                )
                ->add('distrit_type', null, array(
                    'group_by' => 'distrit_type',
                    'choices' => $this->getTypeByCategoryByLanguage("distrit", $this->container->get('request')->getLocale()),
                    'property' => 'languages.values[0].description',
                    'required' => true,
                    'label' => 'distrit'
                        )
                )
                ->add('email', 'email', array(
                    'label' => 'email'
                        )
                )
                ->add('groupblod_type', null, array(
                    'group_by' => 'groupblod_type',
                    'choices' => $this->getTypeByCategoryByLanguage("groupblod", $this->container->get('request')->getLocale()),
                    'property' => 'languages.values[0].description',
                    'required' => true,
                    'label' => 'group_blod'
                        )
                )
                ->add('phone', null, array(
                    'label' => 'phone'
                        )
                )
                ->add('phonemovil', null, array(
                    'label' => 'phone_movil'
                        )
                )
                ->add('sex_type', null, array(
                    'group_by' => 'sex_type',
                    'choices' => $this->getTypeByCategoryByLanguage("sex", $this->container->get('request')->getLocale()),
                    'property' => 'languages.values[0].description',
                    'required' => true,
                    'label' => 'sex'
                        )
                )
                ->add('status', null, array(
                    'label' => 'status'
                        )
                )
                ->add('image', 'sonata_media_type', array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'default',
                    'label' => 'media',
                    'required' => false
                ));
        ;
    }

    public function getName() {
        return 'esolving_shopcartB_update_profile';
    }

}