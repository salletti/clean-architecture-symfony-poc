<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserDataValidator
{
    private ValidatorInterface $validator;
    private Assert\Collection $constraint;

    public function __construct(ValidatorInterface $validator)
    {
        $this->constraint = new Assert\Collection([
            'email' => new Assert\Required([
                new Assert\Email(),
            ]),
            'isPosted' => new Assert\Optional([
                new Assert\Type('string')
            ]),
            'password' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Length(null, 8, 50),
            ]),
            'firstName' => new Assert\Required([
                new Assert\NotBlank()
            ]),
            'lastName' => new Assert\Required([
                new Assert\NotBlank()
            ]),
            'save' => new Assert\Optional(),
        ]);
        $this->validator = $validator;
    }

    public function gerErrors(?array $registerUserData): ?array
    {
        $violations = $this->validator->validate($registerUserData, $this->constraint);
        if (\count($violations) === 0) {
            return null;
        }

        $messages = [];
        foreach ($violations as $violation) {
            $messages[] = [
                $violation->getPropertyPath() => $violation->getMessage(),
            ];
        }

        return $messages;
    }
}
