<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ServiceAdmin extends Admin {

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

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id', null, array("label" => "id"))
                ->add('categories', null, array("label" => "categories"))
                ->add('price', null, array("label" => "price"))
                ->add('languages', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                        )
                )
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with("service")
                ->add('categories', null, array(
                    "label" => 'categories',
                    'required' => false
                        )
                )
                ->add('price', null, array("label" => 'price'))
                ->add('stock', null, array("label" => 'stock'))
                ->add('image', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'default')))
                ->with('languages')
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
                ->add('categories', null, array("label" => 'categories'))
                ->add('price', null, array("label" => 'price'))
                ->add('image', null, array(
                    "label" => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
                ))
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
                ->add('id', null, array('label' => 'id'))
                ->add('categories', null, array("label" => 'categories'))
                ->add('price', null, array("label" => 'date_born'))
        ;
    }

}