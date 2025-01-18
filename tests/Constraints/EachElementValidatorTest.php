<?php

declare(strict_types=1);

namespace OmgFinally\SymfonyValidationConstraints\Test\Constraints;

use OmgFinally\SymfonyValidationConstraints\Constraints\EachElement;
use OmgFinally\SymfonyValidationConstraints\Constraints\EachElementValidator;
use Symfony\Component\Validator\Constraints\NotBlank;
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
        $this->validator->validate('array', new EachElement('numeric'));
    }

    public function testIntConstraintSuccess(): void
    {
        $constraint = new EachElement('int');
        $array = [1, 2, 3];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testIntConstraintFail(): void
    {
        $constraint = new EachElement('int');
        $array = [1, 2, '3'];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testNumericConstraintSuccess(): void
    {
        $constraint = new EachElement('numeric');
        $array = [1, 2, 3, '10'];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testNumericConstraintFail(): void
    {
        $constraint = new EachElement('numeric');
        $array = [1, 2, 3, 'a'];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testAlphaConstraintSuccess(): void
    {
        $constraint = new EachElement('alpha');
        $array = ['a', 'b', 'c'];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testAlphaConstraintFail(): void
    {
        $constraint = new EachElement('alpha');
        $array = ['a', 'b', 'c', 1];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testAlphaNumericConstraintSuccess(): void
    {
        $constraint = new EachElement('alnum');
        $array = ['a', 'b', 'c', 1, 2, 3, '10'];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testAlphaNumericConstraintFail(): void
    {
        $constraint = new EachElement('alnum');
        $array = ['a', 'b', 'c', []];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }
}
