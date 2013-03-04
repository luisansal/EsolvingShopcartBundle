<?php

namespace Esolving\ShopcartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DataminingSellerController extends Controller {

    /**
     * @Secure(roles="ROLE_TREASURY, ROLE_SYSTEM")
     */
    public function checkAction() {
        $form = $this->createForm($this->get('esolving_shopcart.form.type.check'));
        $request = $this->getRequest();
        $items = null;

        if ($request->isMethod('GET')) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $options = array(
                    'best_sellers' => $data['best_sellers'],
                    'bad_sellers' => $data['bad_sellers'],
                    'date_start' => $data['date_start'],
                    'date_end' => $data['date_end'],
                    'just_date' => $data['just_date'],
                    'language' => $this->getRequest()->getLocale(),
                    'categoryId' => $data['category']
                );
                $items = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Item')->findByCriteria($options);
//                if (!$items && !$request->isXmlHttpRequest()) {
//                    throw $this->createNotFoundException('Not found by criteria');
//                }
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate($items, $this->getRequest()->get('page', 1), 10);
            }
        }
        if ($request->isXmlHttpRequest()) {
            return $this->render('EsolvingShopcartBundle:DataMiningSeller:checkAjax.html.twig', array(
                        'form' => $form->createView(),
                        'items' => $items
                    ));
        }

        return $this->render('EsolvingShopcartBundle:DataMiningSeller:check.html.twig', array(
                    'form' => $form->createView(),
                    'items' => compact('pagination')
                ));
    }

}

?>
