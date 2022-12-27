<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register;

use App\Domain\User\Entity\User;

final class RegisterUserResponse
{
    private ?array $violations;
    private ?User $user;

    public function getViolations(): ?array
    {
        return $this->violations;
    }

    public function setViolations(?array $violations): void
    {
        $this->violations = $violations;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
