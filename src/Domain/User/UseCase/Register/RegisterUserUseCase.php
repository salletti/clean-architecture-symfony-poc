<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register;

use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserIsAlreadyRegistered;

final class RegisterUserUseCase implements RegisterUserUseCaseInterface
{
    private UserRepositoryInterface $userRepository;
    private UserIsAlreadyRegistered $userIsAlreadyRegistered;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserIsAlreadyRegistered $userIsAlreadyRegistered,
    ) {
        $this->userRepository = $userRepository;
        $this->userIsAlreadyRegistered = $userIsAlreadyRegistered;
    }

    public function execute(
        RegisterUserRequest $registerRequest,
        RegisterUserPresenterInterface $presenter
    ): void {
        $registerResponse = new RegisterUserResponse();
        $registerResponse->setUser(null);
        $registerResponse->setViolations(null);
        if ($registerRequest->violations) {
            $registerResponse->setViolations($registerRequest->violations);
        }

        if ($registerRequest->isPosted && null === $registerRequest->violations) {
            try {
                $user = $this->saveUser($registerRequest);
                $registerResponse->setUser($user);
            } catch (UserAlreadyRegisteredException $exception) {
                $registerResponse->setViolations([['email' => $exception->getMessage()]]);
            }
        }

        $presenter->present($registerResponse);
    }

    /**
     * @throws UserAlreadyRegisteredException
     */
    private function saveUser(RegisterUserRequest $registerRequest): User
    {
        if ($this->userIsAlreadyRegistered->isSatisfiedBy($registerRequest->email)) {
            throw UserAlreadyRegisteredException::withEmail($registerRequest->email);
        }

        $user = User::createUser(
            $registerRequest->id,
            $registerRequest->email,
            $registerRequest->password,
            $registerRequest->firstName,
            $registerRequest->lastName
        );
        $this->userRepository->add($user);

        return $user;
    }
}
