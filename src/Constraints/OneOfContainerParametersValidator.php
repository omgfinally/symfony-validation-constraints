<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class OneOfContainerParametersValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ContainerInterface $container
    )
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof OneOfContainerParameters) {
            throw new UnexpectedTypeException($constraint, OneOfContainerParameters::class);
        }

        if (false === is_string($value) && false === is_int($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $parameter = $this->container->getParameter($constraint->parameterName);

        if (false === is_array($parameter)) {
            throw new UnexpectedValueException($parameter, 'array');
        }

        if (false === in_array($value, $parameter, true)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
