<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\View;

use App\Presentation\User\RegisterUserJsonViewModel;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterJsonView
{
    public function generateView(
        RegisterUserJsonViewModel $viewModel
    ): JsonResponse {
        if ($viewModel->violations) {
            return new JsonResponse($viewModel->violations, 400);
        }

        return new JsonResponse(
            [
                'id' => $viewModel->id,
                'email' => $viewModel->email,
                'lastName' => $viewModel->firstName,
                'firstName' => $viewModel->lastName,
            ]
        );
    }
}
