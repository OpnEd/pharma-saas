<?php

namespace Src\Admin\User\Domain\ValueObjects;


class UserName {

    private string $username;

    public function __construct(string $username)
    {
        if (strlen($username) < 3) {
            throw new \InvalidArgumentException("Username must be at least 3 characters long.");
        }
        $this->username = $username;
    }

    public function value(): string
    {
        return $this->username;
    }
}
