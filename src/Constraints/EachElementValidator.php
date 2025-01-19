<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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

        $fakeContext = clone $this->context;

        foreach ($value as $element) {
            foreach ($constraint->subConstraints as $subConstraint) {
                $fakeContext->getViolations()->addAll($this->runChecks($element, $subConstraint));
            }
        }

        $countValues = count($value);
        $countViolations = $fakeContext->getViolations()->count();
        $maxViolations = $countValues * count($constraint->subConstraints);

        if (
            ($constraint->logicalOperator === 'and' && $countViolations > 0)
            || ($constraint->logicalOperator === 'or' && $countViolations === $maxViolations)
            || ($constraint->logicalOperator === 'not' && $countViolations < $maxViolations)
        ) {
            $this->context->getViolations()->addAll($fakeContext->getViolations());
        }
    }

    private function runChecks(mixed $element, Constraint $constraint): ConstraintViolationListInterface
    {
        $validatorClassname = $constraint->validatedBy();
        /** @var ConstraintValidatorInterface $validator */
        $validator = new $validatorClassname();
        $fakeContext = clone $this->context;
        $validator->initialize($fakeContext);
        $validator->validate($element, $constraint);
        return $fakeContext->getViolations();
    }
}
