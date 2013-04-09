<?php

namespace Esolving\ShopcartBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EqualsFields extends Constraint {

    public $message = 'this_value_does_not_equal_to_field';
    public $required = true;
    public $field;
    public $label;

    public function validatedBy() {
        return 'EqualsFieldsValidator';
    }

//    /**
//     * {@inheritDoc}
//     */
//    public function getDefaultOption()
//    {
//        return 'field';
//    }
// 
//    /**
//     * {@inheritDoc}
//     */
//    public function getRequiredOptions()
//    {
//        return array('field');
//    }
}