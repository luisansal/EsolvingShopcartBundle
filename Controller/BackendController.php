<?php

namespace Esolving\ShopcartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class BackendController extends Controller {

    public function loginBackendAction($name = null) {
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
        return $this->render('EsolvingShopcartBundle:Backend:loginBackend.html.twig', array(
                    // el último nombre de usuario ingresado por el usuario
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                ));
    }

}
