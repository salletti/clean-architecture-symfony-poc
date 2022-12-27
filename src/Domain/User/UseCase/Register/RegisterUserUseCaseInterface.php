<?php

namespace App\Domain\User\UseCase\Register;

interface RegisterUserUseCaseInterface
{
    public function execute(RegisterUserRequest $registerRequest, RegisterUserPresenterInterface $presenter): void;
}
