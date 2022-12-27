<?php

declare(strict_types=1);

namespace App\Presentation\User;

use App\Domain\User\UseCase\Register\RegisterUserPresenterInterface;
use App\Domain\User\UseCase\Register\RegisterUserResponse;

final class RegisterUserHtmlPresenter implements RegisterUserPresenterInterface
{
    private RegisterUserHtmlViewModel $viewModel;

    public function present(RegisterUserResponse $response): void
    {
        $this->viewModel = new RegisterUserHtmlViewModel();
        $this->viewModel->email = $response->getUser()?->getEmail();
        $this->viewModel->violations = $response->getViolations();
    }

    public function viewModel(): RegisterUserHtmlViewModel
    {
        return $this->viewModel;
    }
}
