<?php

namespace Src\Admin\User\Domain\ValueObjects;

class UserRememberToken
{
    private string $token;

    public function __construct(string $token)
    {
        if ($token === '') {
            throw new \InvalidArgumentException('Remember token cannot be empty.');
        }

        if (strlen($token) > 100) {
            throw new \InvalidArgumentException('Remember token cannot be longer than 100 characters.');
        }

        $this->token = $token;
    }

    public function value(): string
    {
        return $this->token;
    }
}
