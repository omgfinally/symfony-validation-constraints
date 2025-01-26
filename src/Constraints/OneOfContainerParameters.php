<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class OneOfContainerParameters extends Constraint
{
    public function __construct(
        public string $parameterName,
        public string $message = "The value is not within the parameters configuration.",
        ?array        $groups = null,
                      $payload = null
    )
    {
        parent::__construct([], $groups, $payload);
    }
}
