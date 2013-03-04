<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Esolving\ShopcartBundle\Entity\Setting;
use Esolving\ShopcartBundle\Repository\TypeRepository;

class SettingAdmin extends Admin {

    protected $maxPerPage = 30;
    protected $translationDomain = 'EsolvingShopcartBundle';

    public function getSetting($current_setting_id) {
        return $getDistrit = $this
                ->getConfigurationPool()
                ->getContainer()
                ->get("doctrine")
                ->getRepository('EsolvingShopcartBundle:Type')
                ->findSettingTypeNoRepeatByLanguage($this->getRequest()->getLocale(), $current_setting_id);
        ;
    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('setting_type', null, array("label" => 'setting'))
                ->add('value', null, array("label" => 'value'))
                ->add('status', null, array("label" => 'status'))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $id = $this->getRequest()->get($this->getIdParameter());
        $formMapper
                ->with("general")
                ->add('setting_type', null, array(
                    'group_by' => 'setting_type',
                    'choices' => $this->getSetting($id),
                    'property' => 'languages.values[0].description',
                    'required' => true,
                    'label' => 'setting'
                ))
                
                ->add('name', null, array("label" => 'name'))
                ->add('value', null, array("label" => 'value'))
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

    public function getSex() {
        return $getSex = $this
                ->getConfigurationPool()
                ->getContainer()
                ->get("doctrine")
                ->getRepository("EsolvingShopcartBundle:Type")
                ->findByCategoryByLanguage("sex", $this->getRequest()->getLocale());
        ;
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('setting_type', null, array(
                    "label" => 'setting',
                    'template' => 'EsolvingShopcartBundle::setting.html.twig',
                ))
                ->add('name', null, array("label" => 'name'))
                ->add('value', null, array("label" => 'value'))
                ->add('languages', null, array("label" => 'languages'))
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
        $datagridMapper
                ->add('setting_type', null, array("label" => 'setting'))
                ->add('value', null, array("label" => 'value'))
                ->add('status', null, array("label" => 'status'))
        ;
    }

}