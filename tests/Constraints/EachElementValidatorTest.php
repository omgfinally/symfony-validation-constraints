<?php

declare(strict_types=1);

namespace Constraints;

use OmgFinally\SymfonyValidationConstraints\Constraints\EachElement;
use OmgFinally\SymfonyValidationConstraints\Constraints\EachElementValidator;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Component\Validator\Validation;

class EachElementValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new EachElementValidator();
    }

    public function testUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate([], new NotBlank());
    }

    public function testUnexpectedValueException(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate('array', new EachElement([]));
    }

    public function testOneConstraintSuccess(): void
    {
        $constraint = new EachElement(new Type('int'));
        $array = [10, 20];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testOneConstraintFail(): void
    {
        $constraint = new EachElement(new Type('int'));
        $array = [10, '20'];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testMultipleConstraintsWithAndLogicalOperatorSuccess(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'and'
        );
        $array = [10, 20];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testMultipleConstraintsWithAndLogicalOperatorFail(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'and'
        );
        $array = [-10, 20];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testMultipleConstraintsWithOrLogicalOperatorSuccess(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'or'
        );
        $array = [-10, 20];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testMultipleConstraintsWithOrLogicalOperatorFail(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'or'
        );
        $array = [false, false];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(4, $violations, \sprintf('4 violations expected. Got %u.', \count($violations)));
    }

    public function testOneConstraintWithNotLogicalOperatorSuccess(): void
    {
        $constraint = new EachElement(
            subConstraints: new Type('int'),
            logicalOperator: 'not'
        );
        $array = ['a', 'b'];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testOneConstraintWithNotLogicalOperatorFail(): void
    {
        $constraint = new EachElement(
            subConstraints: new Type('int'),
            logicalOperator: 'not'
        );
        $array = [1, 'a'];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testMultipleConstraintsWithNotLogicalOperatorSuccess(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'not'
        );
        $array = [false, false];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testMultipleConstraintsWithNotLogicalOperatorFail(): void
    {
        $constraint = new EachElement(
            subConstraints: [new Type('int'), new Positive()],
            logicalOperator: 'not'
        );
        $array = [1, false];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(2, $violations, \sprintf('2 violations expected. Got %u.', \count($violations)));
    }
}
