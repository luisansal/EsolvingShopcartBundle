<?php

namespace Esolving\ShopcartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Esolving\ShopcartBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * User controller.
 *
 */
class UserController extends Controller {

    public function createOnlyUserAction() {
        $user = new User();
        $form = $this->createForm($this->get('esolving_shopcart.form.type.user_only'), $user);
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $password = $this->setCodeAndSecurePassword($user);
                $em->persist($user);
                $em->flush();
                $message = \Swift_Message::newInstance()
                        ->setSubject($this->get('translator')->trans('you_was_registered', array(), 'EsolvingShopcartBundle'))
                        ->setFrom($this->get('service_container')->getParameter('email_master'))
                        ->setTo($user->getEmail())
                        ->setBody($this->renderView('EsolvingShopcartBundle:User:register.txt.twig', array('user' => $user, 'password' => $password)), 'text/html')
                ;
                $this->get('mailer')->send($message);
            }
        }
        return $this->render('EsolvingShopcartBundle:User:createOnlyUser.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function forgotPasswordAction() {
        
    }

    public function homeAction() {
//        $plugin = $this->get('payment.plugin.paypal_express_checkout');

        return $this->render('EsolvingShopcartBundle:User:home.html.twig', array());
    }

    public function deleteAction($user_id) {
        $user = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:User')->findOneByIdByLanguage($user_id, $this->getRequest()->getLocale());

        $formDelete = $this->createFormBuilder(array('id' => $user_id))
                ->add('id', 'hidden')
                ->getForm();
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $formDelete->bind($request);
            if ($formDelete->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if (!$user) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }

                $em->remove($user);
                $em->flush();
                return $this->redirect($this->generateUrl('esolving_shopcartB_User_show'));
            }
        }
        return $this->render('EsolvingShopcartBundle:User:delete.html.twig', array(
                    'user' => $user,
                    'form' => $formDelete->createView()
                ));
    }

    /**
     * @Secure(roles="ROLE_SYSTEM")
     */
    public function editAction($user_id) {
        // verifica el acceso para edición
//        $securityContext = $this->get('security.context');
//        if (false === $securityContext->isGranted('EDIT', $user)) {
//            throw new AccessDeniedException();
//        }
        $user = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:User')->find($user_id);
        if (!$user) {
            throw $this->createNotFoundException('Not found user');
        }
        $form = $this->createForm($this->get('esolving_shopcart.form.type.user'), $user);
        $info = null;
        $status = 0;
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $info = $this->get('translator')->trans("updated", array(), "EsolvingShopcartBundle");
                $status = 1;
            }
        }
        return $this->render('EsolvingShopcartBundle:User:edit.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                    'info' => $info,
                    'status' => $status
                ));
    }

    /**
     * @Secure(roles="ROLE_SYSTEM")
     */
    public function showAction() {
        $parameters = array(
            'sort' => $this->get('request')->query->get('sort'),
            'direction' => $this->get('request')->query->get('direction')
        );

        $users = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:User')->findAllByLanguage($this->getRequest()->getLocale(), $parameters);
//        $paginator->setSortableTemplate('EsolvingShopcartBundle:Pagination:button_sortable_link.html.twig');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($users, $this->get('request')->query->get('page', 1)/* page number */, 10/* limit per page */);
//        $pagination->setCurrentPageNumber($this->get('request')->query->get('page', 2));
//        $pagi = new \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination($engine, $routerHelper, $translator, $parameters);
        $users = compact('pagination');
        return $this->render('EsolvingShopcartBundle:User:show.html.twig', array(
                    'users' => $users
                ));
    }

    /**
     * @Secure(roles="ROLE_SYSTEM")
     */
    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm($this->get('esolving_shopcart.form.type.user'), $user);
        $status = 0;
        $info = "";
        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                try {
                    $em->getConnection()->beginTransaction();
                    $em->persist($user);
                    $em->flush();
                    $password = $this->setCodeAndSecurePassword($user);
                    $em->persist($user);
                    $em->flush();
                    $message = \Swift_Message::newInstance()
                            ->setSubject($this->get('translator')->trans('you_was_registered', array(), 'EsolvingShopcartBundle'))
                            ->setFrom($this->get('service_container')->getParameter('email_master'))
                            ->setTo($user->getEmail())
                            ->setBody($this->renderView('EsolvingShopcartBundle:User:register.txt.twig', array('user' => $user, 'password' => $password)), 'text/html')
                    ;
                    $this->get('mailer')->send($message);

//                    // creando la ACL
//                    $aclProvider = $this->get('security.acl.provider');
//                    $objectIdentity = ObjectIdentity::fromDomainObject($user);
//                    $acl = $aclProvider->createAcl($objectIdentity);
//
//                    // recupera la identidad de seguridad del usuario registrado actual
//                    $securityContext = $this->get('security.context');
//                    $user = $securityContext->getToken()->getUser();
//                    $securityIdentity = UserSecurityIdentity::fromAccount($user);
//
//                    // otorga permiso de propietario
//                    $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
//                    $aclProvider->updateAcl($acl);

                    $em->getConnection()->commit();
                    $status = 1;
                } catch (\Exception $e) {
                    $em->getConnection()->rollback();
                    $status = -1;
                }
                if ($status == 1) {
                    $info = $this->get('translator')->trans('registered', array(), 'EsolvingShopcartBundle');
//                    $this->get('session')->getFlashBag()->add('notice', $info);
                } else if ($status == 0) {
                    $info = $this->get('translator')->trans('cant_registered', array(), 'EsolvingShopcartBundle');
                } else if ($status == -1) {
                    $info = $this->get('translator')->trans('not_registered', array(), 'EsolvingShopcartBundle');
                }
            } else {
                $info = $this->get('translator')->trans('is_not_valid', array(), 'EsolvingShopcartBundle');
            }
        }

        return $this->render('EsolvingShopcartBundle:User:register.html.twig', array(
                    'form' => $form->createView(),
                    'info' => $info,
                    'status' => $status
                        )
        );
    }

    private function setCodeAndSecurePassword(User $user) {
        $userId = $user->getId();
        $code = date("Y", time()) . str_repeat("0", 6 - strlen($userId)) . $userId;
        $password = substr(sha1($code), 0, 6);
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodePassword = $encoder->encodePassword($password, $user->getSalt());
        $user->file = null;
        $user->setCode($code);
        $user->setPassword($encodePassword);
        return $password;
    }

    public function profileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Not found user by id ' . $this->getUser()->getId());
        }
//        $form = $this->createForm(new UserUpdateType(), $user);
        $form = $this->createForm($this->get('esolving_shopcart.form.type.user_update'), $user);
        $info = "";
        $status = 0;
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            // This isn't a great practice
//            $postData = $request->get('esolving_eschool_userB_update_profile');
//            $actualPassword = $postData['actualPassword'];
//            $passwordRepeated = $postData['passwordRepeated']; get first and second in array
            $actualPassword = $form->get("actualPassword")->getData();
            $passwordRepeated = $form->get('passwordRepeated')->getData();
//            $sex_type = $form->get('sex_type')->getData();
            if ($form->isValid()) {
                try {
                    $em->getConnection()->beginTransaction();
                    if (!empty($actualPassword) && !empty($passwordRepeated)) {
                        $factory = $this->get('security.encoder_factory');
                        $encoder = $factory->getEncoder($user);
                        $password = $encoder->encodePassword($passwordRepeated, $this->getUser()->getSalt());
                        $user->setPassword($password);
                    }
                    $em->persist($user);
                    $em->flush();
                    $em->getConnection()->commit();
                    $status = 1;
                } catch (\Exception $e) {
                    $em->getConnection()->rollback();
                    $status = -1;
                }
                if ($status == 1) {
                    $info = $this->get('translator')->trans('updated', array(), 'EsolvingShopcartBundle');
                } else if ($status == 0) {
                    $info = $this->get('translator')->trans('cant_updated', array(), 'EsolvingShopcartBundle');
                } else if ($status == -1) {
                    $info = $this->get('translator')->trans('not_updated', array(), 'EsolvingShopcartBundle');
                }
            } else {
                $info = $this->get('translator')->trans('not_valid_form', array(), 'EsolvingShopcartBundle');
            }
        }
        return $this->render('EsolvingShopcartBundle:User:profile.html.twig', array(
                    'form' => $form->createView(),
                    'info' => $info,
                    'status' => $status
                ));
    }

}