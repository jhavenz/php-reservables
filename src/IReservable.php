<?php

namespace Jhavenz\PhpTimeslotReservations;

interface IReservable
{
    public function reserve(ITimeslot $timeslot);

    public function cancel(ITimeslot $timeslot);

    public function isReserved(): bool;

    public function reschedule(ITimeslot $timeslot);
}
