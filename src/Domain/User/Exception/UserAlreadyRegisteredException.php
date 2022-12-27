<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

final class UserAlreadyRegisteredException extends \Exception
{
    public static function withEmail(string $email): self
    {
        return new self(\sprintf('user with email %s is already registered', $email));
    }
}
