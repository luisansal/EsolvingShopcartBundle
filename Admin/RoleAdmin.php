<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RoleAdmin extends Admin {

    protected $maxPerPage = 10;
    protected $translationDomain = 'EsolvingShopcartBundle';

    public function getTypeRole() {
        $doctrine = $this->getConfigurationPool()
                ->getContainer()
                ->get("doctrine");
        return $getGroupblod = $doctrine
                ->getRepository('EsolvingShopcartBundle:Type')
                ->findRoleTypeNoRepeatByLanguage($this->getRequest()->getLocale());
        ;
    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('role_type', null, array("label" => "role_type"))
//                ->add('user', null, array("label" => "user"))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with("general")
                ->add('role_type', null, array(
                    'choices' => $this->getTypeRole(),
                    'property' => 'languages.values[0].description',
                    'required' => true,
                    'label' => 'role'
                ))
//                ->add("users", null, array("required" => false))
                ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('role_type', null, array("label" => 'role'))
//                ->add('users', null, array("label" => 'user'))
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
        $datagridMapper
                ->add('role_type', null, array("label" => 'role'))
//                ->add('users', null, array("label" => 'user'))
        ;
    }

}