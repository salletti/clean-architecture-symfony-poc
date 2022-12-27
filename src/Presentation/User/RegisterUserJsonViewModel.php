<?php

declare(strict_types=1);

namespace App\Presentation\User;

final class RegisterUserJsonViewModel
{
    public ?string $id;
    public ?string $email;
    public ?string $firstName;
    public ?string $lastName;
    public ?array $violations;
}
