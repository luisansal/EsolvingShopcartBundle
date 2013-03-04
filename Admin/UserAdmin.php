<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\MediaBundle\Entity\BaseMedia as Media;

class UserAdmin extends Admin {

    protected $maxPerPage = 10;
//  Default load messages translations.
//    protected $translationDomain = 'messages';
    protected $translationDomain = 'EsolvingShopcartBundle';

    public function getTypeByCategoryByLanguage($xcategory, $xlanguage) {
        return $getSex = $this
                ->getConfigurationPool()
                ->getContainer()
                ->get("doctrine")
                ->getRepository("EsolvingShopcartBundle:Type")
                ->findByCategoryByLanguage($xcategory, $xlanguage);
        ;
    }

    public function getAllRoleByLanguage($xlanguage) {
        return $getSex = $this
                ->getConfigurationPool()
                ->getContainer()
                ->get('doctrine')
                ->getRepository("EsolvingShopcartBundle:Role")
                ->findAllByLanguage($xlanguage);
        ;
    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('name', null, array("label" => "name"))
                ->add('lastname', null, array("label" => "last_name"))
                ->add('dateborn', null, array("label" => "date_born"))
                ->add('phone', null, array("label" => "phone"))
                ->add('phonemovil', null, array("label" => "phone_movil"))
                ->add('email', null, array("label" => "email"))
                ->add('address', null, array("label" => "address"))
                ->add('code', null, array("label" => "code"))
                ->add('password', null, array("label" => "password"))
                ->add('dateregistered', null, array("label" => "date_registered"))
                ->add('datemodificated', null, array("label" => "date_modificated"))
                ->add('datedisabled', null, array("label" => "date_disabled"))
                ->add('sex_type', null, array("label" => "sex"))
                ->add('distrit_type', null, array("label" => "distrit"))
                ->add('groupblod_type', null, array("label" => "group_blod"))
                ->add('status', null, array("label" => "status"))
                ->add('image', null, array(
                    "label" => 'image'
                ))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        if (!$this->isChild()) {
            $formMapper
//            ->with('Options', array('collapsed' => true))
//            ->add('enabled', null, array('required' => false))
                    ->with('general')
//                    ->add('sex_type','sonata_type_immutable_array', array(
//                'keys' => array(
////                    array('content', 'textarea', array()),
////                    array('public', 'checkbox', array()),
//                    array("asdf",'choice', array('choices' => array(1 => 'type 1', 2 => 'type 2')))
//                )))
//                    ->add('sex_type', 'sonata_type_model')
//                    ->add('sex_type', 'sonata_type_model_list', array(), array())
//                    ->add('sex_type', 'sonata_type_model', array("choices" => $this->getSex(), "expanded" => false, 'label' => 'sex'))
                    ->add('sex_type', null, array(
//                        'class' => 'Esolving\ShopcartBundle\Entity\Type',
                        'group_by' => 'sex_type',
                        'choices' => $this->getTypeByCategoryByLanguage('sex', $this->getRequest()->getLocale()),
                        'property' => 'languages.values[0].description',
                        'required' => true,
                        'label' => 'sex'
                    ))
                    ->add('groupblod_type', null, array(
                        'group_by' => 'groupblod_type',
                        'choices' => $this->getTypeByCategoryByLanguage('groupblod', $this->getRequest()->getLocale()),
                        'property' => 'languages.values[0].description',
                        'required' => true,
                        'label' => 'group_blod'
                    ))
                    ->add('distrit_type', null, array(
                        'group_by' => 'distrit_type',
                        'choices' => $this->getTypeByCategoryByLanguage('distrit', $this->getRequest()->getLocale()),
                        'property' => 'languages.values[0].description',
                        'required' => true,
                        'label' => 'distrit'
                    ))
            ;
        }

        $formMapper
                ->with('role')
                ->add('rolesaccess', null, array(
                    'choices' => $this->getAllRoleByLanguage($this->getRequest()->getLocale()),
                    'property' => 'roleType.languages.values[0].description',
                    'label' => 'roles_access'
                        )
                )
//                ->add('roles', 'sonata_type_collection', array('required' => true, 'by_reference' => false, 'label' => 'roles'), array(
//                    'edit' => 'inline',
//                    'inline' => 'table'
//                ))
                ->with("general")
                ->add('name', null, array("label" => 'name'))
                ->add('lastname', null, array("label" => 'last_name'))
                ->add('dateborn', null, array(
                    "label" => 'date_born',
//                    'widget' => 'single_text',
                    'years' => range(date('Y') - 60, date('Y') + 10)
                        )
                )
                ->add('phone', null, array("label" => 'phone'))
                ->add('phonemovil', null, array("label" => 'phone_movil'))
                ->add('email', null, array("label" => 'email'))
                ->add('address', null, array("label" => 'address'))
//                ->add('code', null, array("label" => 'code'))
//                ->add('password', null, array("label" => 'password'))
                ->add('status', null, array("label" => 'status'))
                ->add('image', 'sonata_type_model_list', array('label' => 'media', 'required' => false), array(
                    'link_parameters' => array('context' => 'default'),
                ))
//                ->add('file', 'file', array(
//                    "label" => 'imagen',
//                    'required' => false
//                ))
                ->end()
        ;
    }

    public function postPersist($user) {
        parent::postPersist($user);
        $em = $this->getConfigurationPool()
                        ->getContainer()
                        ->get('doctrine')->getManager();
        $userId = $user->getId();
        $code = date("Y", time()) . str_repeat("0", 6 - strlen($userId)) . $userId;
        $password = substr(sha1($code), 0, 6);
        $factory = $this->getConfigurationPool()
                ->getContainer()
                ->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodePassword = $encoder->encodePassword($password, $user->getSalt());
        $user->file = null;
        $user->setCode($code);
        $user->setPassword($encodePassword);
        $em->persist($user);
        $em->flush();
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name', null, array("label" => 'name'))
                ->add('lastname', null, array("label" => 'last_name'))
                ->add('rolesaccess', null, array("label" => 'roles'))
                ->add('dateborn', null, array("label" => 'date_born'))
                ->add('phone', null, array("label" => 'phone'))
                ->add('phonemovil', null, array("label" => 'phone_movil'))
                ->add('email', null, array("label" => 'email'))
                ->add('address', null, array("label" => 'address'))
                ->add('code', null, array("label" => 'code'))
//                ->add('password', null, array("label" => 'password'))
                ->add('dateregistered', null, array("label" => 'date_registered'))
                ->add('datemodificated', null, array("label" => 'date_modificated'))
                ->add('datedisabled', null, array("label" => 'date_disabled'))
                ->add('sex_type', null, array("label" => 'sex'))
                ->add('distrit_type', null, array("label" => 'distrit'))
                ->add('groupblod_type', null, array("label" => 'group_blod'))
                ->add('image', null, array(
                    "label" => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
                ))
                ->add('status', null, array("label" => 'status'))
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        'view' => array()
                    ),
                    "label" => 'actions'
                ))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
//        $datagridMapper
//                ->add('tags', null, array('filter_field_options' => array('expanded' => true, 'multiple' => true)))
//        ;        
        $datagridMapper
                ->add('name', null, array("label" => 'name'))
                ->add('lastname', null, array("label" => 'last_name'))
                ->add('dateborn', null, array("label" => 'date_born'))
                ->add('phone', null, array("label" => 'phone'))
                ->add('phonemovil', null, array("label" => 'phone_movil'))
                ->add('email', null, array("label" => 'email'))
                ->add('address', null, array("label" => 'address'))
                ->add('code', null, array("label" => 'code'))
                ->add('password', null, array("label" => 'password'))
                ->add('dateregistered', null, array("label" => 'date_registered'))
                ->add('datemodificated', null, array("label" => 'date_modificated'))
                ->add('datedisabled', null, array("label" => 'date_disabled'))
                ->add('sex_type', null, array('field_options' => array('choices' => $this->getTypeByCategoryByLanguage('sex', $this->getRequest()->getLocale())), "label" => 'sex'))
                ->add('groupblod_type', null, array('field_options' => array('choices' => $this->getTypeByCategoryByLanguage('groupblod', $this->getRequest()->getLocale())), "label" => 'group_blod'))
                ->add('distrit_type', null, array('field_options' => array('choices' => $this->getTypeByCategoryByLanguage('distrit', $this->getRequest()->getLocale())), "label" => 'distrit'))
                ->add('status', null, array("label" => 'status'))
        ;
    }

}