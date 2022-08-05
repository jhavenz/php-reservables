<?php

namespace Jhavenz\PhpTimeslotReservations;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Carbon\CarbonTimeZone;
use DateTime;

use function Jhavenz\CarbonHelpers\carbon;
use function Jhavenz\CarbonHelpers\carbonImmutable;

class Timeslot
{
    protected CarbonImmutable $end;
    protected CarbonImmutable $start;

    public function __construct(
        null|DateTime|int|string $start = null,
        protected int $hours = 1,
        protected int $minutes = 0,
        protected CarbonTimeZone $timezone = new CarbonTimeZone()
    ) {
        $this->start = carbonImmutable($start, $this->timezone->getName());
        $this->setEnd();
    }

    public static function after(ITimeslot $timeslot, ?CarbonInterval $duration = null): static
    {
        $start = $timeslot->end();

        /** @noinspection PhpUnhandledExceptionInspection */
        $duration = $duration ?? CarbonInterval::create(0, 0, 0, 0, 0, 0, $start->secondsUntil($timeslot->end()));

        //$start = $start->add($duration);

        return new static($start, $duration->hours, $duration->minutes);
    }

    public static function before(Timeslot $timeslot): static
    {
        $start = clone $timeslot->start();
        $hours = $timeslot->hours();
        $minutes = $timeslot->minutes();

        return new static($start->subHours($hours)->subMinutes($minutes), $hours, $minutes);
    }

    public static function create(
        null|DateTime|int|string $start = null,
        int $hours = 1,
        int $minutes = 0,
        CarbonTimeZone $timezone = new CarbonTimeZone()
    ): static {
        return new static($start, $hours, $minutes, $timezone);
    }

    public function end(): CarbonImmutable
    {
        return $this->end;
    }

    public function has(\DateTimeInterface|string|int $datetime): bool
    {
        return $this->toPeriod()->contains(carbon($datetime));
    }

    public function hours(): int
    {
        return $this->hours;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }

    public static function now(bool $round = true): Timeslot
    {
        $self = static::create(CarbonImmutable::now());

        return $round ? $self->round() : $self;
    }

    public function round(): static
    {
        $this->start->minute(0);
        $this->setEnd();

        return $this;
    }

    protected function setEnd(): void
    {
        $this->end = $this->start
            ->addHours($this->hours)
            ->addMinutes($this->minutes)
            ->subSecond();
    }

    public function start(): CarbonImmutable
    {
        return $this->start;
    }

    public function toArray(): array
    {
        return $this->toInterval()->toArray();
    }

    public function toInterval(): CarbonInterval
    {
        return $this->start()->diffAsCarbonInterval($this->end());
    }

    public function toPeriod(): CarbonPeriod
    {
        return CarbonPeriod::dates($this->start(), $this->end())
            ->setDateClass(CarbonImmutable::class);
    }
}
