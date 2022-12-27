<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register;

final class RegisterUserRequest
{
    public ?bool $isPosted = null;

    public ?string $id;

    public ?string $email;

    public ?string $password;

    public ?string $firstName;

    public ?string $lastName;

    public ?array $violations = null;
}
