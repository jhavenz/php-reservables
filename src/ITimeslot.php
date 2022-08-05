<?php

namespace Jhavenz\PhpTimeslotReservations;

use Carbon\CarbonImmutable;

interface ITimeslot
{
    public function end(): CarbonImmutable;

    public function start(): CarbonImmutable;
}
