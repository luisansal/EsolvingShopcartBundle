<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends Admin {

    protected $maxPerPage = 10;
//  Default load messages translations.
//    protected $translationDomain = 'messages';
    protected $translationDomain = 'EsolvingShopcartBundle';

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id', null, array("label" => "id"))
                ->add('services', null, array("label" => "service"))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with("category")
                ->add('services', null, array(
                    'label' => 'services', 'required' => false
                ))
                ->with("languages")
                ->add('languages', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                        )
                )
                ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id', null, array("label" => 'id'))
                ->add('services', null, array("label" => 'service'))
                ->add('languages', null, array('label' => 'languages'))
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
                ->add('id', null, array("label" => 'id'))
                ->add('services', null, array("label" => 'service'))
        ;
    }

}