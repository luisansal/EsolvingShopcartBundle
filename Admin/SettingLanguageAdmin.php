<?php

namespace Esolving\ShopcartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SettingLanguageAdmin extends Admin {

    protected $maxPerPage = 10;
    protected $translationDomain = 'EsolvingShopcartBundle';

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('language', null, array("label" => 'language'))
                ->add('description', null, array("label" => 'description'))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $languages = $this->getConfigurationPool()->getContainer()->get("esolving_shopcart.core")->getLanguages();
        foreach ($languages as $languageK => $language) {
            $choiceLanguages[$languageK] = $language;
        }
        $formMapper
                ->with("general")
                ->add('language', "choice", array(
                    "label" => 'language',
                    "choices" => $choiceLanguages))
                ->add('description', null, array("label" => 'description'))
                ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('language', null, array("label" => 'language'))
                ->add('description', null, array("label" => 'description'))
                ->add('setting', null, array("label" => 'setting'))
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        'view' => array()
                    )
                ))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('language', null, array("label" => 'language'))
                ->add('description', null, array("label" => 'description'))
        ;
    }

}