<?php

namespace Src\Admin\User\Application\Commands;

readonly class CreateUserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null
    ) {}
}