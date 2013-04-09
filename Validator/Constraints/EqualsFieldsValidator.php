<?php

namespace Esolving\ShopcartBundle\Validator\constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Translation\Translator;

class EqualsFieldsValidator extends ConstraintValidator {
    
    private $translator;
    
    public function __construct(Translator $translator) {
        $this->translator = $translator;
    }
// This is only with field in entity
// example: $value->getName()
//    public function getTargets() {
//        return self::CLASS_CONSTRAINT;
//    }

    public function validate($value, Constraint $constraint) {
        if($constraint->required){
            $required= true;
        } else {
            $required = $value ? true:false;
        }
        if ($value != $this->context->getRoot()->get($constraint->field)->getData() && $required) {
            $this->context->addViolation($constraint->message, array(
                '{{ field }}' => $this->translator->trans($constraint->label,array(),'EsolvingEschoolDisplayBundle'),
                    ), null);
        }
//        if (!preg_match('/^[a-zA-Za0-9]+$/', $value, $matches)) {
//            $this->context->addViolation($constraint->message, array('%string%' => $value));
//        }
    }

}