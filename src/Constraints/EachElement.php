<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EachElement extends Constraint
{
    public function __construct(
        public array|Constraint $subConstraints,
        public string $message = "One of the elements of your array did not meet the constraint criteria.",
        ?array $groups = null,
        $payload = null
    )
    {
        parent::__construct([], $groups, $payload);
    }
}
