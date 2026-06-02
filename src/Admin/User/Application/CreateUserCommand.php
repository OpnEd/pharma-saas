<?php

namespace Src\Admin\User\Application;

readonly class CreateUserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}