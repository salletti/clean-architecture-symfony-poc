<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepositoryInterface;

final class UserIsAlreadyRegistered
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isSatisfiedBy(string $email): bool
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        return $user !== null;
    }
}
