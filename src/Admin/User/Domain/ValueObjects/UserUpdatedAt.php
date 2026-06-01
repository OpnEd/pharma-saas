<?php

namespace Src\Admin\User\Domain\ValueObjects;

use DateTimeImmutable;
use DateTimeInterface;

class UserUpdatedAt
{
    private DateTimeImmutable $updatedAt;

    public function __construct(string|DateTimeInterface $updatedAt)
    {
        if (is_string($updatedAt)) {
            $date = date_create_immutable($updatedAt);
            if ($date === false) {
                throw new \InvalidArgumentException('Invalid updated at timestamp.');
            }
            $updatedAt = $date;
        }

        if (!$updatedAt instanceof DateTimeImmutable) {
            $updatedAt = DateTimeImmutable::createFromMutable($updatedAt);
        }

        $this->updatedAt = $updatedAt;
    }

    public function value(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function formatted(): string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }
}
