<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\ParamConverter;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use App\Infrastructure\Symfony\Service\RegisterUserDataValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

final class JsonToRegisterUserRequest implements ParamConverterInterface
{
    private RegisterUserDataValidator $registerUserDataValidator;

    public function __construct(RegisterUserDataValidator $registerUserDataValidator)
    {
        $this->registerUserDataValidator = $registerUserDataValidator;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $registerUserData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $registerRequest = new RegisterUserRequest();
        $registerRequest->violations = $this->registerUserDataValidator->gerErrors($registerUserData ?? null);
        $registerRequest->isPosted = true;
        $registerRequest->email = $registerUserData['email'] ?? null;
        $registerRequest->password = $registerUserData['password'] ?? null;
        $registerRequest->firstName = $registerUserData['firstName'] ?? null;
        $registerRequest->lastName = $registerUserData['lastName'] ?? null;
        $registerRequest->id = Uuid::v4()->toRfc4122();

        $request->attributes->set($configuration->getName(), $registerRequest);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return
            'registerUserRequest' === $configuration->getName() &&
            'JsonToRegisterUserRequest' === $configuration->getConverter()
        ;

    }
}
