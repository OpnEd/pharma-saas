<?php

namespace Src\Admin\User\Application\Commands;

readonly class UpdateUserCommand
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email
    ) {}
}