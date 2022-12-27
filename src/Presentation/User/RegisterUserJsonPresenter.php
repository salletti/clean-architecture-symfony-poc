<?php

declare(strict_types=1);

namespace App\Presentation\User;

use App\Domain\User\UseCase\Register\RegisterUserPresenterInterface;
use App\Domain\User\UseCase\Register\RegisterUserResponse;

final class RegisterUserJsonPresenter implements RegisterUserPresenterInterface
{
    private RegisterUserJsonViewModel $viewModel;

    public function present(RegisterUserResponse $response): void
    {
        $this->viewModel = new RegisterUserJsonViewModel();
        $this->viewModel->id = $response->getUser()?->getId();
        $this->viewModel->email = $response->getUser()?->getEmail();
        $this->viewModel->firstName = $response->getUser()?->getFirstName();
        $this->viewModel->lastName = $response->getUser()?->getLastName();
        $this->viewModel->violations = $response->getViolations();
    }

    public function viewModel(): RegisterUserJsonViewModel
    {
        return $this->viewModel;
    }
}
