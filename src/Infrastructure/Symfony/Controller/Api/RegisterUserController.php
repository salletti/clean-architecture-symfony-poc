<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Api;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use App\Domain\User\UseCase\Register\RegisterUserUseCaseInterface;
use App\Infrastructure\Symfony\View\RegisterJsonView;
use App\Presentation\User\RegisterUserJsonPresenter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/register", name="api_register", methods={"POST"})
 * @ParamConverter(
 *     name="registerUserRequest",
 *     converter="JsonToRegisterUserRequest",
 * )
 */
final class RegisterUserController extends AbstractController
{
    private RegisterJsonView $registerView;
    private RegisterUserUseCaseInterface $registerUseCase;
    private RegisterUserJsonPresenter $presenter;

    public function __construct(
        RegisterJsonView $registerView,
        RegisterUserUseCaseInterface $registerUseCase,
        RegisterUserJsonPresenter $registerUserPresenter
    ) {
        $this->registerView = $registerView;
        $this->registerUseCase = $registerUseCase;
        $this->presenter = $registerUserPresenter;
    }

    public function __invoke(RegisterUserRequest $registerUserRequest): JsonResponse
    {
        $this->registerUseCase->execute($registerUserRequest, $this->presenter);

        return $this->registerView->generateView($this->presenter->viewModel());
    }
}
