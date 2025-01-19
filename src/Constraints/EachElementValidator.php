<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EachElementValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof EachElement) {
            throw new UnexpectedTypeException($constraint, EachElement::class);
        }

        if (false === is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (
            false === is_array($constraint->subConstraints)
            && !$constraint->subConstraints instanceof Constraint
        ) {
            throw new UnexpectedValueException($value, 'array or Constraint');
        }

        if (is_array($constraint->subConstraints)) {
            foreach($constraint->subConstraints as $subConstraint) {
                $this->runChecks($value, $subConstraint);
            }
        } else {
            $this->runChecks($value, $constraint->subConstraints);
        }
    }

    private function runChecks(mixed $value, Constraint $constraint): void
    {
        $validatorClassname = $constraint->validatedBy();
        $validator = new $validatorClassname();
        $validator->initialize($this->context);

        foreach($value as $el) {
            $validator->validate($el, $constraint);
        }
    }
}
