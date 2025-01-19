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

    public function testIntConstraintSuccess(): void
    {
        $constraint = new EachElement(new Type('int'));
        $array = [1, 2, 3];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testIntConstraintFail(): void
    {
        $constraint = new EachElement(new Type('int'));
        $array = [1, 2, '3'];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }

    public function testPositiveIntConstraintSuccess(): void
    {
        $constraint = new EachElement([new Type('int'), new Positive()]);
        $array = [1, 2, 3];

        $this->validator->validate($array, $constraint);
        $this->assertNoViolation();
    }

    public function testPositiveIntConstraintFail(): void
    {
        $constraint = new EachElement([new Type('int'), new Positive()]);
        $array = [-10, 1, 2, 3];
        $validator = Validation::createValidator();
        $violations = $validator->validate($array, $constraint);
        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
    }
}
