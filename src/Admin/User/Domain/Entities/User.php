<?php

namespace Src\Admin\User\Domain\Entities;

use Src\Admin\User\Domain\ValueObjects\UserCreatedAt;
use Src\Admin\User\Domain\ValueObjects\UserEmail;
use Src\Admin\User\Domain\ValueObjects\UserEmailVerifiedAt;
use Src\Admin\User\Domain\ValueObjects\UserName;
use Src\Admin\User\Domain\ValueObjects\UserPassword;
use Src\Admin\User\Domain\ValueObjects\UserRememberToken;
use Src\Admin\User\Domain\ValueObjects\UserUpdatedAt;

class User
{
    private ?int $id;
    private UserName $username;
    private UserEmail $email;
    private ?UserPassword $password;
    private ?UserEmailVerifiedAt $emailVerifiedAt;
    private ?UserRememberToken $rememberToken;
    private ?UserCreatedAt $createdAt;
    private ?UserUpdatedAt $updatedAt;

    public function __construct(
        ?int $id,
        UserName $username,
        UserEmail $email,
        ?UserPassword $password = null,
        ?UserEmailVerifiedAt $emailVerifiedAt = null,
        ?UserRememberToken $rememberToken = null,
        ?UserCreatedAt $createdAt = null,
        ?UserUpdatedAt $updatedAt = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->rememberToken = $rememberToken;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->username;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): ?UserPassword
    {
        return $this->password;
    }

    public function emailVerifiedAt(): ?UserEmailVerifiedAt
    {
        return $this->emailVerifiedAt;
    }

    public function rememberToken(): ?UserRememberToken
    {
        return $this->rememberToken;
    }

    public function createdAt(): ?UserCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?UserUpdatedAt
    {
        return $this->updatedAt;
    }
}
