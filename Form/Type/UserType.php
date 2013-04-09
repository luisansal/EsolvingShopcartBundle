<?php

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;

class UserType extends AbstractType {

    private $container;
    private $em;

    public function __construct(Container $container, EntityManager $em) {
        $this->container = $container;
        $this->em = $em;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => 'EsolvingShopcartBundle',
            'data_class' => 'Esolving\ShopcartBundle\Entity\User'
        ));
    }

    public function getTypeByCategoryByLanguage($xcategory, $xlanguage) {
        return $getSex = $this
                ->em
                ->getRepository("EsolvingShopcartBundle:Type")
                ->findByCategoryByLanguage($xcategory, $xlanguage);
        ;
    }

    public function getAllRoleByLanguageExceptAdmin($xlanguage) {
        $roles = $this->em->getRepository('EsolvingShopcartBundle:Role')->findAllByLanguageExceptAdmin($xlanguage);
        return $roles;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, array(
//                    'constraints' => array(new NotBlank(), new MinLength(20)),
                    'label' => 'name'
                        )
                )
                ->add('lastname', null, array(
                    'label' => 'last_name'
                        )
                )
                ->add('address', null, array(
                    'label' => 'address'
                        )
                )
                ->add('dateborn', null, array(
                    'label' => 'date_born',
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
                ->add('rolesaccess', null, array(
                    'group_by' => 'rolesaccess',
                    'choices' => $this->getAllRoleByLanguageExceptAdmin($this->container->get('request')->getLocale()),
                    'property' => 'role_type.languages.values[0].description',
                    'label' => 'roles_access'
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
        return 'esolving_shopcartB_profile';
    }

}