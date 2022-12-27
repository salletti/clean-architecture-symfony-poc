<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\ParamConverter;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use App\Infrastructure\Symfony\Service\RegisterUserDataValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

final class FormToRegisterUserRequest implements ParamConverterInterface
{
    private RegisterUserDataValidator $registerUserDataValidator;

    public function __construct(RegisterUserDataValidator $registerUserDataValidator)
    {
        $this->registerUserDataValidator = $registerUserDataValidator;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $registerUserData = $request->request->all();
        $registerRequest = new RegisterUserRequest();
        $isPosted = $registerUserData['register_user']['isPosted'] ?? null;
        if ($isPosted !== null) {
            $registerRequest->violations = $this->registerUserDataValidator->gerErrors($registerUserData['register_user'] ?? null);
            $registerRequest->isPosted = (bool)(int) $isPosted;
            $registerRequest->email = $registerUserData['register_user']['email'] ?? null;
            $registerRequest->password = $registerUserData['register_user']['password'] ?? null;
            $registerRequest->firstName = $registerUserData['register_user']['firstName'] ?? null;
            $registerRequest->lastName = $registerUserData['register_user']['lastName'] ?? null;
            $registerRequest->id = Uuid::v4()->toRfc4122();
        }

        $request->attributes->set($configuration->getName(), $registerRequest);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return
            'registerUserRequest' === $configuration->getName() &&
            'FormToRegisterUserRequest' === $configuration->getConverter()
        ;
    }
}
