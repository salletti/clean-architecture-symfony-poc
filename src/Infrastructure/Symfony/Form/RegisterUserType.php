<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Form;

use App\Domain\User\UseCase\Register\RegisterUserRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isPosted', HiddenType::class, ['data' => true])
            ->add('email', null, ['required' => true])
            ->add('firstName', null, ['required' => true])
            ->add('lastName', null, ['required' => true])
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => RegisterUserRequest::class,
                'csrf_protection' => false,
            ]
        );
    }
}
