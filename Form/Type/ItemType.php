<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esolving\ShopcartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Cart item type.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('quantity', null, array(
                    'label' => 'quantity',
                    'attr' => array('class' => 'center-text')
                        )
                )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver
                ->setDefaults(array(
                    'translation_domain' => 'EsolvingShopcartBundle',
                    'data_class' => 'Esolving\ShopCartBundle\Entity\Item'
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'esolving_shopcartB_Shop_cart_item';
    }

}
