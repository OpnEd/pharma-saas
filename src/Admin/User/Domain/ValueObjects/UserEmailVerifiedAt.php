<?php

namespace Src\Admin\User\Domain\ValueObjects;

use DateTimeImmutable;
use DateTimeInterface;

class UserEmailVerifiedAt
{
    private DateTimeImmutable $verifiedAt;

    public function __construct(string|DateTimeInterface $verifiedAt)
    {
        if (is_string($verifiedAt)) {
            $date = date_create_immutable($verifiedAt);
            if ($date === false) {
                throw new \InvalidArgumentException('Invalid email verified at timestamp.');
            }
            $verifiedAt = $date;
        }

        if (!$verifiedAt instanceof DateTimeImmutable) {
            $verifiedAt = DateTimeImmutable::createFromMutable($verifiedAt);
        }

        $this->verifiedAt = $verifiedAt;
    }

    public function value(): \DateTimeImmutable
    {
        return $this->verifiedAt;
    }

    public function formatted(): string
    {
        return $this->verifiedAt->format('Y-m-d H:i:s');
    }
}
