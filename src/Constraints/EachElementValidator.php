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

        if ('int' === $constraint->method && $this->validateElements($value, function(mixed $v) {return is_int($v);})) {
            return;
        }

        if ('numeric' === $constraint->method && $this->validateElements($value, function(mixed $v) {return is_numeric($v);})) {
            return;
        }

        if ('alpha' === $constraint->method && $this->validateElements($value, function(mixed $v) {return ctype_alpha($v);})) {
            return;
        }

        if ('alnum' === $constraint->method && $this->validateElements($value, function(mixed $v) {return ctype_alpha($v) || is_numeric($v);})) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }

    private function validateElements(array $elements, callable $method): bool
    {
        foreach($elements as $element) {
            if (!$method($element)) {
                return false;
            }
        }

        return true;
    }
}
