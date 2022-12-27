<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\View;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use App\Infrastructure\Symfony\Form\RegisterUserType;
use App\Presentation\User\RegisterUserHtmlViewModel;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class RegisterHtmlView
{
    private Environment $twig;
    private FormFactoryInterface $formFactory;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
    }

    public function generateView(
        RegisterUserRequest $registerUserRequest,
        RegisterUserHtmlViewModel $viewModel
    ): Response {
        if (!$viewModel->violations && $registerUserRequest->isPosted) {
            return new Response($this->twig->render(
                'user/register_complete.html.twig',
                [
                    'viewModel' => $viewModel
                ]
            ));
        }

        $form = $this->formFactory->createBuilder(RegisterUserType::class, $registerUserRequest)->getForm();

        return new Response($this->twig->render(
            'user/register.html.twig',
            [
                'form' => $form->createView(),
                'viewModel' => $viewModel
            ]
        ));
    }
}
