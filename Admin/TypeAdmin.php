<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Esolving\ShopcartBundle\Entity\Language;

class TypeAdmin extends Admin {

    protected $maxPerPage = 30;
    protected $translationDomain = 'EsolvingShopcartBundle';

//    public function postPersist($object) {
//        parent::postPersist($object);
//        $typeId = $this
//                ->getConfigurationPool()
//                ->getContainer()
//                ->get("doctrine")
//                ->getRepository('EsolvingEschoolTypeBundle:Type')
//                ->find($object->getId())
//        ;
//        $languages = $this->getConfigurationPool()->getContainer()->get("display")->languages();
//        foreach ($languages as $languagesV) {
//            $language = new Language();
//            $language->setDescription($object->getName());
//            $language->setLanguage($languagesV->getFilename());
//            $language->setType($typeId);
//            $em = $this
//                    ->getConfigurationPool()
//                    ->getContainer()
//                    ->get("doctrine")
//                    ->getEntityManager()
//            ;
//            $em->persist($language);
//        }
//        $em->flush();
//    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('category', null, array("label" => 'category'))
                ->add('name', null, array("label" => 'name'))
                ->add('status', null, array("label" => 'status'))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with("general")
                ->add('category', null, array("label" => 'category'))
                ->add('name', null, array("label" => 'name'))
                ->add('status', null, array("label" => 'status'))
                ->with("languages")
                ->add('languages', 'sonata_type_collection', array(
                    'required' => true,
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
                ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name', null, array("label" => 'name'))
                ->add('status', null, array("label" => 'status'))
                ->add('languages', null, array("label" => 'category'))
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
                ->add('category', null, array("label" => 'category'))
                ->add('name', null, array("label" => 'name'))
                ->add('status', null, array("label" => 'status'))
        ;
    }

}