<?php

namespace Esolving\ShopcartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Esolving\ShopcartBundle\Type;
use Symfony\Component\HttpFoundation\Response;
use Esolving\ShopcartBundle\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class GuestController extends Controller {

    public function javascriptDisabledAction() {
        return $this->render('EsolvingShopcartBundle:Guest:javascriptDisabled.html.twig', array());
    }

    public function setLanguageAction($route) {
//        $this->getRequest()->setLocale($this->getRequest()->get('ddlbLanguages'));
        $_locale = $this->getRequest()->get('ddlbLanguage');
        return $this->redirect($this->generateUrl($route, array('_locale' => $_locale)));
//        return $this->redirect($this->generateUrl($this->getRequest()->get('_route')));
    }

    public function indexAction() {
        $datetime = new \DateTime('now');
        $dateObject = $datetime;
//        $session = $this->getRequest()->getSession();
//        $locale = $session->set('language', 'es');
//        $session->clear('language');
//        echo $session->get('language');
//        $this->getRequest()->setLocale('en');
//        echo $this->container->get('request')->getRequestUri();
        return $this->render("EsolvingShopcartBundle:Guest:index.html.twig", array('dateObject' => $dateObject));
    }

    public function servicesAction() {

        return $this->render("EsolvingShopcartBundle:Guest:services.html.twig", array());
    }

    public function contactAction(Request $request) {
        $form = $this->createForm(new ContactType());
//        $contact = $request->get('guest_contact');
//        echo $contact['name'];
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                
            } else {
                
            }
        }
        // return a template dependents if isxmlhttrequest is true or false
        if ($this->getRequest()->isXmlHttpRequest()) {
//            return $this->render("EsolvingShopcartBundle:Guest:contact_errors.html.twig", array(
//                        'form' => $form->createView(),
//                    ));
            return $this->render("EsolvingShopcartBundle:Guest:contact_errors.json.twig", array(
                        'form' => $form->createView(),
                    ));
        }
        return $this->render("EsolvingShopcartBundle:Guest:contact.html.twig", array(
                    'form' => $form->createView(),
                ));
    }

    public function newsAction() {


        return $this->render("EsolvingShopcartBundle:Guest:news.html.twig", array());
    }

    public function logInAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the error of the login if exist an error
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
//      $request = $this->getRequest();
//      print_r($request->get('_username'));
//      echo $this->get('request')->get('_username');
        return $this->render('EsolvingShopcartBundle:Guest:login.html.twig', array(
                    // el último nombre de usuario ingresado por el usuario
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                ));
    }

//    public function logInRequiredAction() {
//        if ($this->getRequest()->isMethod('POST')) {
//            // Logueamos al usuario
//            $username = $this->getRequest()->get('_username');
//            $password = $this->getRequest()->get('_password');
//            $user = new \Esolving\ShopcartBundle\Entity\User();
//            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
//            $passwordEncoder = $encoder->encodePassword($password, $user->getSalt());
////            $getUser = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:User')->findBy(array('code' => $username,'password'=>$passwordEncoder));
//
//            $token = new UsernamePasswordToken($username, $password, 'secured_area',array('ROLE_USER'));
//            
//            $this->get('security.context')->setToken($token);
//            return $this->redirect($this->generateUrl('esolving_shopcartB_index'));
//        }
//
//
//        return $this->render('EsolvingShopcartBundle:Guest:loginRequired.html.twig', array(
//                    // el último nombre de usuario ingresado por el usuario
////                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
////                    'error' => $error,
//                    'last_username' => '',
//                    'error' => '',
//                ));
//    }

}
