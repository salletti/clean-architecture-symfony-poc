<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

final class User
{
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $id;

    public function __construct(
        string $id,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public static function createUser(
        string $id,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ): self {
        return new self($id, $email, $password, $firstName, $lastName);
    }
}
