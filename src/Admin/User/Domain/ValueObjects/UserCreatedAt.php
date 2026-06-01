<?php

namespace Src\Admin\User\Domain\ValueObjects;

use DateTimeImmutable;
use DateTimeInterface;

class UserCreatedAt
{
    private DateTimeImmutable $createdAt;

    public function __construct(string|DateTimeInterface $createdAt)
    {
        if (is_string($createdAt)) {
            $date = date_create_immutable($createdAt);
            if ($date === false) {
                throw new \InvalidArgumentException('Invalid created at timestamp.');
            }
            $createdAt = $date;
        }

        if (!$createdAt instanceof DateTimeImmutable) {
            $createdAt = DateTimeImmutable::createFromMutable($createdAt);
        }

        $this->createdAt = $createdAt;
    }

    public function value(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function formatted(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
