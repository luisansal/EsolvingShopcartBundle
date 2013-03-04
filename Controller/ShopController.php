<?php

namespace Esolving\ShopcartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Esolving\ShopcartBundle\Entity\Cart;
use Esolving\ShopcartBundle\Entity\Item;
use Esolving\ShopcartBundle\Entity\CartModeration;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 */
class ShopController extends Controller {

    /**
     * @Secure(roles="ROLE_SYSTEM")
     */
    public function moderatesAction() {
        $cartModeration = new CartModeration();
        $cartModerates = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:CartModeration')->findAllByStatus(true);
        foreach ($cartModerates as $cartModerateV) {
            $success = new \Esolving\ShopcartBundle\Entity\ArrayCollectionSuccess();
            $success->success = $cartModerateV->getSuccess();
            $cartModeration->getSuccess()->add($success);

            $cart = new \Esolving\ShopcartBundle\Entity\ArrayCollectionCart();
            $cart->cart = $cartModerateV->getCart()->getId();
            $cartModeration->getCarts()->add($cart);
        }
        $form = $this->createForm(new \Esolving\ShopcartBundle\Form\Type\CartModerationType(), $cartModeration);
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $em = $this->getDoctrine()->getManager();

            if ($form->isValid()) {
                $carts = $form->get('carts')->getData();
                $success = $form->get('success')->getData();
                foreach ($carts as $cartK => $cartV) {
                    if (!$success[$cartK]->success) {
                        $cartModeration = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:CartModeration')->findOneBy(array(
                            'cart' => $cartV->cart
                                ));
                        $cartModeration->setSuccess($success[$cartK]->success);
                        $cartModeration->setDatemodificated(new \Datetime());
                        $em->persist($cartModeration);
                        $message = \Swift_Message::newInstance()
                                ->setSubject($this->get('translator')->trans('sorry_was_an_error_in_your_payment', array(), 'EsolvingShopcartBundle'))
                                ->setFrom($this->get('service_container')->getParameter('email_master'))
                                ->setTo($cartModeration->getCart()->getUser()->getEmail())
                                ->setBody($this->renderView('EsolvingShopcartBundle:Shop:error_confirmation_payment.txt.twig', array('cart' => $cartModeration->getCart(), 'paymentMethod' => $cartModeration->getPaymentMethod())), 'text/html')
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
                $em->flush();
                return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_moderates'));
            }
        }
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($cartModerates, $this->getRequest()->get('page', 1), 10);
        return $this->render('EsolvingShopcartBundle:Shop:moderates.html.twig', array(
                    'cartModerates' => compact('pagination'),
                    'form' => $form->createView()
                ));
    }

    /**
     * @Secure(roles="ROLE_SYSTEM")
     */
    public function noModeratesAction(Request $request) {
        $cartModeration = new CartModeration();
        $cartNoModerates = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:CartModeration')->findAllByStatus(false);
        foreach ($cartNoModerates as $cartNoModerateV) {
            $success = new \Esolving\ShopcartBundle\Entity\ArrayCollectionSuccess();
            $success->success = $cartNoModerateV->getSuccess();
            $cartModeration->getSuccess()->add($success);

            $cart = new \Esolving\ShopcartBundle\Entity\ArrayCollectionCart();
            $cart->cart = $cartNoModerateV->getCart()->getId();
            $cartModeration->getCarts()->add($cart);
        }

        $form = $this->createForm(new \Esolving\ShopcartBundle\Form\Type\CartModerationType(), $cartModeration);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            $em = $this->getDoctrine()->getManager();

            if ($form->isValid()) {
                $carts = $form->get('carts')->getData();
                $success = $form->get('success')->getData();

                foreach ($carts as $cartK => $cartV) {
                    if ($success[$cartK]->success) {
                        $cartModeration = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:CartModeration')->findOneBy(array(
                            'cart' => $cartV->cart
                                ));
                        $cartModeration->setSuccess($success[$cartK]->success);
                        $cartModeration->setDateSuccess(new \Datetime());
                        $em->persist($cartModeration);
                        $message = \Swift_Message::newInstance()
                                ->setSubject($this->get('translator')->trans('confirmation_of_payment', array(), 'EsolvingShopcartBundle'))
                                ->setFrom($this->get('service_container')->getParameter('email_master'))
                                ->setTo($cartModeration->getCart()->getUser()->getEmail())
                                ->setBody($this->renderView('EsolvingShopcartBundle:Shop:confirmation_payment.txt.twig', array('cart' => $cartModeration->getCart(), 'paymentMethod' => $cartModeration->getPaymentMethod())), 'text/html')
                        ;
                        $this->get('mailer')->send($message);
                    }
                }
                $em->flush();

                return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_no_moderates'));
            }
        }

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($cartNoModerates, $this->getRequest()->get('page', 1), 10);
        return $this->render('EsolvingShopcartBundle:Shop:noModerates.html.twig', array(
                    'cartNoModerates' => compact('pagination'),
                    'form' => $form->createView()
                ));
    }

    /**
     * Paypal
     * @return type
     * @throws type
     */
    public function cartPaypalAction() {
        $request = $this->getRequest();
        $formCartPaypal = $request->getQueryString();
        $twig = $this->container->get('twig');
        $globals = $twig->getGlobals();
        $url = $globals['global']['paypal'];
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($this->getUser()->getId(), $this->getRequest()->getLocale());
        if (!$cart) {
            throw $this->createNotFoundException('Unable to find item.');
        }
        $em = $this->getDoctrine()->getManager();

        $cart_moderation = new CartModeration();
        $cart_moderation->setCart($cart);
        $cart_moderation->setPaymentMethod('paypal');
        $cart->setStatus('0');

        $em->persist($cart);
        $em->persist($cart_moderation);
        $message = \Swift_Message::newInstance()
                ->setSubject($this->get('translator')->trans('thanks_for_paypal_payment', array(), 'EsolvingShopcartBundle'))
                ->setFrom($this->get('service_container')->getParameter('email_master'))
                ->setTo($this->getUser()->getEmail())
                ->setBody($this->renderView('EsolvingShopcartBundle:Shop:paypal.txt.twig', array('cart' => $cart)), 'text/html')
        ;
        $this->get('mailer')->send($message);
        $em->flush();

        return $this->redirect($url . '?' . $formCartPaypal);
    }

    /**
     * Transfer
     * @return type
     * @throws type
     */
    public function cartBuyEndAction() {
        $em = $this->getDoctrine()->getManager();
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($this->getUser()->getId(), $this->getRequest()->getLocale());
        if (!$cart) {
            throw $this->createNotFoundException('Not found cart');
        }
        $cart_moderation = new CartModeration();
        $cart_moderation->setCart($cart);
        $cart_moderation->setPaymentMethod('transfer');
        $cart->setStatus('0');
        $em->persist($cart);
        $em->persist($cart_moderation);

        $message = \Swift_Message::newInstance()
                ->setSubject($this->get('translator')->trans('confirm_us_your_check_out', array(), 'EsolvingShopcartBundle'))
                ->setFrom($this->get('service_container')->getParameter('email_master'))
                ->setTo($this->getUser()->getEmail())
                ->setBody($this->renderView('EsolvingShopcartBundle:Shop:transfer.txt.twig', array('cart' => $cart)), 'text/html')
        ;
        $this->get('mailer')->send($message);
        $em->flush();
        return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_cart'));
//        return new Response("Email Enviado");
    }

    public function cartBuyMethodAction() {
        $request = $this->getRequest();
        $form = $this->createForm(new \Esolving\ShopcartBundle\Form\Type\CartBuyMethodType());
        return $this->render('EsolvingShopcartBundle:Shop:cartBuyMethod.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function cartBuyStep1Action(Request $request) {
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($this->getUser()->getId(), $this->getRequest()->getLocale());
        $form = $this->createForm(new \Esolving\ShopcartBundle\Form\Type\CartType(), $cart);
        $formMethod = $request->get('esolving_shopcartB_Shop_cart_method');
        $method = $formMethod['method'];
        switch ($method) {
            case 0:
                $methodDescription = $this->get('translator')->trans('paypal', array(), 'EsolvingShopcartBundle');
                break;
            case 1;
                $methodDescription = $this->get('translator')->trans('transfer', array(), 'EsolvingShopcartBundle');
                ;

                break;
        }

        return $this->render('EsolvingShopcartBundle:Shop:cartBuyStep1.html.twig', array(
                    'method_index' => $method,
                    'method_description' => $methodDescription,
                    'cart' => $cart,
                    'form' => $form->createView()
                        )
        );
    }

    public function shopAction($category_id, $category) {

        $services = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Service')->findAllByCategoryIdByLanguage($category_id, $this->getRequest()->getLocale());

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($services, $this->getRequest()->get('page', 1), 10);

        return $this->render("EsolvingShopcartBundle:Shop:shop.html.twig", array(
                    'category' => $category,
                    'services' => compact('pagination')
                        )
        );
    }

    public function shopNewsAction() {
        $services = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Service')->findAllMaxByLanguage(10, $this->getRequest()->getLocale());

        return $this->render("EsolvingShopcartBundle:Shop:shopNews.html.twig", array(
                    'services' => $services
                        )
        );
    }

    public function showServiceAction($service_id, $category) {
        $service = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Service')->findOneByIdByLanguage($service_id, $this->getRequest()->getLocale());

        return $this->render('EsolvingShopcartBundle:Shop:showService.html.twig', array(
                    'category' => $category,
                    'service' => $service,
                        )
        );
    }

    public function addItemServiceToCartAction($service_id, $service) {
        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Service')->find($service_id);

        $user = $this->getUser();
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($user->getId(), $this->getRequest()->getLocale());

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setTotalItems('0');
            $cart->setTotalPrice('0');

            $item = new Item();
            $item->setService($service);
            $item->setCart($cart);

            $em->persist($cart);
            $em->persist($item);
        } else {
            $getItem = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Item')->findOneByServiceIdByCartIdNoSuccess($service_id, $cart->getId());

            if ($getItem) {
                $getItem->addQuantity();
                $em->persist($getItem);
            } else {
                $item = new Item();
                $item->setService($service);
                $item->setCart($cart);
                $em->persist($item);
            }
            $this->updateCartTotalItemsAndTotalPrice($em, $cart, $this->getRequest()->getLocale());
        }
        $em->flush();
        return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_cart', array()));
    }

    public function updateCartTotalItemsAndTotalPrice(\Doctrine\ORM\EntityManager $em, \Esolving\ShopcartBundle\Entity\Cart $cart, $language) {
        $items = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Item')->findAllItemByCartIdByLanguage($cart->getId(), $language);
        if ($items) {
            $totalItems = 0;
            $totalPrice = 0;
            foreach ($items as $itemV) {
                $serviceV = $itemV->getService();
                $totalItems += $itemV->getQuantity();
                $totalPrice += $itemV->getQuantity() * $serviceV->getPrice();
            }
            $cart->setTotalItems($totalItems);
            $cart->setTotalPrice($totalPrice);
            $em->persist($cart);
        }
        $em->flush();
    }

    public function deleteItemAction($item_id) {
        $item = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Item')->find($item_id);
        if (!$item) {
            throw $this->createNotFoundException('Unable to find item.');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $user = $this->getUser();
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($user->getId(), $this->getRequest()->getLocale());

        if ($cart) {
            $this->updateCartTotalItemsAndTotalPrice($em, $cart, $this->getRequest()->getLocale());
            $items = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Item')->findAllItemByCartIdByLanguage($cart->getId(), $this->getRequest()->getLocale());
            if (!$items) {
                $em->remove($cart);
            }
        }
        $em->flush();

        return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_cart', array()));
    }

    public function cartAction(Request $request) {
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($this->getUser()->getId(), $this->getRequest()->getLocale());
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new \Esolving\ShopcartBundle\Form\Type\CartType(), $cart);
        if ($cart) {
            $this->updateCartTotalItemsAndTotalPrice($em, $cart, $this->getRequest()->getLocale());
        }
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($cart);
                $em->flush();
                $this->updateCartTotalItemsAndTotalPrice($em, $cart, $this->getRequest()->getLocale());
                return $this->redirect($this->generateUrl('esolving_shopcartB_Shop_cart'));
            }
        }
        return $this->render("EsolvingShopcartBundle:Shop:cart.html.twig", array(
                    'form' => $form->createView(),
                    'cart' => $cart
                        )
        );
    }

    public function categoriesAction($current_category) {
        $categories = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Category')->findAllByLanguage($this->getRequest()->getLocale());
        $cart = $this->getDoctrine()->getRepository('EsolvingShopcartBundle:Cart')->findOneByUserIdByLanguage($this->getUser()->getId(), $this->getRequest()->getLocale());
        if ($cart) {
            $totalItems = $cart->getTotalItems();
            $totalPrice = $cart->getTotalPrice();
        }

        return $this->render('EsolvingShopcartBundle:Shop:categories.html.twig', array(
                    'categories' => $categories,
                    'current_category' => $current_category,
                    'cart' => $cart
                        )
        );
    }

}