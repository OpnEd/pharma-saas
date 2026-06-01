<?php

namespace Src\Admin\User\Domain\ValueObjects;

class UserPassword
{
    private string $password;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long.');
        }

        $this->password = $password;
    }

    public function value(): string
    {
        return $this->password;
    }
}
