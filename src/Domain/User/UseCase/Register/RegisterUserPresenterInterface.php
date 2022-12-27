<?php

namespace App\Domain\User\UseCase\Register;

interface RegisterUserPresenterInterface
{
    public function present(RegisterUserResponse $response);
}
