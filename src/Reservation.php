<?php

namespace Jhavenz\PhpTimeslotReservations;

class Reservation implements IReservable
{
    public function __construct(
        private bool $isReserved = false,
        private bool $isCancelled = false,
        /** @var Reservation[] $rescheduleHistory */
        private array $previousReservations = []
    ) {}

    public function reserve(ITimeslot $timeslot)
    {
        // TODO: Implement reserve() method.
    }

    public function cancel(ITimeslot $timeslot)
    {
        // TODO: Implement cancel() method.
    }

    public function isReserved(): bool
    {
        // TODO: Implement isReserved() method.
    }

    public function reschedule(ITimeslot $timeslot)
    {
        // TODO: Implement reschedule() method.
    }
}
