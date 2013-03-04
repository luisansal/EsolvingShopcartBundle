<?php

namespace Esolving\ShopcartBundle\Core;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\DependencyInjection\Container;

class Core {

    private $translator;
    private $container;

    public function getTypeByCategoryByLanguage($xcategory, $xlanguage) {
        return $getSex = $this
                ->container
                ->get("doctrine")
                ->getRepository("EsolvingShopcartBundle:Type")
                ->findByCategoryByLanguage($xcategory, $xlanguage);
        ;
    }

    public function __construct(Translator $translator, Container $container) {
        $this->translator = $translator;
        $this->container = $container;
    }

    public function getLanguages() {
//        $finder = new Finder();
//        $languages = $finder->directories()->depth("0")->in("../app/Resources/translations/");
//        return $languages;
        $languages['es'] = $this->translator->trans('spanish', array(), 'EsolvingShopcartBundle');
        $languages['en'] = $this->translator->trans('english', array(), 'EsolvingShopcartBundle');
        $languages['fr'] = $this->translator->trans('french', array(), 'EsolvingShopcartBundle');
        return $languages;
    }

    public function ddlbLanguage() {
        $html = '';
        $html .= '<select name="ddlbLanguage">';
        foreach ($this->getLanguages() as $languageK => $language) {
            $selected = ($languageK == $this->container->get('request')->getLocale()) ? "selected='selected'" : '';
            $html .= '<option value="' . $languageK . '"' . $selected . '>' . $language . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function getSetting($xsetting) {
        $em = $this->container->get('doctrine');
        $setting = $em->getRepository('EsolvingShopcartBundle:Setting')->findOneByNameByLanguage($xsetting, $this->container->get('request')->getLocale());
//        print_r($setting);
        return $setting;
    }

}