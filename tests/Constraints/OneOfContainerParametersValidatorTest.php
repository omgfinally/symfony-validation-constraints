<?php

declare(strict_types=1);

namespace Constraints;

use OmgFinally\SymfonyValidationConstraints\Constraints\OneOfContainerParameters;
use OmgFinally\SymfonyValidationConstraints\Constraints\OneOfContainerParametersValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class OneOfContainerParametersValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        $container = new ContainerBuilder();
        $container->setParameter('valid', ['one', 'two', 3]);
        $container->setParameter('invalid', 'string');
        return new OneOfContainerParametersValidator($container);
    }

    public function testUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate('one', new NotBlank());
    }

    public function testUnexpectedValueException(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate(['one'], new OneOfContainerParameters('valid'));
    }

    public function testUnexpectedParameterException(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate('one', new OneOfContainerParameters('invalid'));
    }

    public function testOneOfContainerParametersIntSuccess(): void
    {
        $this->validator->validate(3, new OneOfContainerParameters('valid'));
        $this->assertNoViolation();
    }

    // todo: will need help with this
//    public function testOneOfContainerParametersFail(): void
//    {
//        $violations = $validator->validate('seven', new OneOfContainerParameters('valid'));
//        $this->assertCount(1, $violations, \sprintf('1 violation expected. Got %u.', \count($violations)));
//    }
}
