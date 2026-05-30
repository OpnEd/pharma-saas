<?php

namespace Src\admin\user\domain\entities;

use Src\admin\user\domain\value_objects\UserEmail;
use Src\admin\user\domain\value_objects\UserName;


class User {

    private int $id;
    private UserName $username;
    private UserEmail $email;

    public function __construct(int $id, UserName $username, UserEmail $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public function name(): UserName
    {
        return $this->username;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function id(): int
    {
        return $this->id;
    }
}
