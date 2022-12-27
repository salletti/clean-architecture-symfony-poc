<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use App\Domain\User\UseCase\Register\RegisterUserUseCaseInterface;
use App\Infrastructure\Symfony\View\RegisterHtmlView;
use App\Presentation\User\RegisterUserHtmlPresenter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/register', name: 'app_register')]
#ParamConverter(name="registerUserRequest", converter="FormToRegisterUserRequest")
final class RegisterUserController extends AbstractController
{
    private RegisterHtmlView $registerView;
    private RegisterUserUseCaseInterface $registerUseCase;
    private RegisterUserHtmlPresenter $presenter;

    public function __construct(
        RegisterHtmlView $registerView,
        RegisterUserUseCaseInterface $registerUseCase,
        RegisterUserHtmlPresenter $presenter
    ) {
        $this->registerView = $registerView;
        $this->registerUseCase = $registerUseCase;
        $this->presenter = $presenter;
    }

    public function __invoke(RegisterUserRequest $registerUserRequest): Response
    {
        $this->registerUseCase->execute($registerUserRequest, $this->presenter);

        return $this->registerView->generateView(
            $registerUserRequest,
            $this->presenter->viewModel()
        );
    }
}
