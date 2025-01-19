<?php

namespace OmgFinally\SymfonyValidationConstraints\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EachElement extends Constraint
{
    public array $subConstraints;
    public string $logicalOperator;

    public function __construct(
        array|Constraint $subConstraints,
        public string    $message = "One of the elements of your array did not meet the constraint criteria.",
        string           $logicalOperator = "and",
        ?array           $groups = null,
                         $payload = null
    )
    {
        parent::__construct([], $groups, $payload);
        if ($subConstraints instanceof Constraint) {
            $subConstraints = [$subConstraints];
        }
        $this->subConstraints = $subConstraints;

        $this->logicalOperator = in_array($logicalOperator, ['and', 'or', 'not']) ? $logicalOperator : 'and';
    }
}
