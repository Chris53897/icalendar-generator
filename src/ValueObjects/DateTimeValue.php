<?php

namespace Spatie\IcalendarGenerator\ValueObjects;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class DateTimeValue
{
    private DateTimeInterface $dateTime;

    private bool $withTime;

    public static function create(
        DateTimeInterface $dateTime,
        bool $withTime = true
    ): self {
        return new self($dateTime, $withTime);
    }

    public function __construct(
        DateTimeInterface $dateTime,
        bool $withTime = true
    ) {
        $this->dateTime = $dateTime;
        $this->withTime = $withTime;
    }

    public function format(): string
    {
        $format = $this->withTime ? 'Ymd\THis' : 'Ymd';

        return $this->dateTime->format($format);
    }

    public function hasTime(): bool
    {
        return $this->withTime;
    }

    public function getDateTime(): DateTimeInterface
    {
        return $this->dateTime;
    }

    public function convertToTimezone(DateTimeZone $dateTimeZone): self
    {
        if (! $this->withTime) {
            return $this;
        }

        $dateTime = $this->dateTime instanceof DateTimeImmutable
            ? DateTime::createFromImmutable($this->dateTime)
            : clone $this->dateTime;

        $this->dateTime = $dateTime->setTimezone($dateTimeZone);

        return $this;
    }

    public function __toString()
    {
        return $this->format();
    }
}
