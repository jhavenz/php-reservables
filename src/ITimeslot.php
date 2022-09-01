<?php

namespace Jhavenz\PhpTimeslotReservations;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

interface ITimeslot
{
    public function duration(): CarbonPeriod;

    public function end(): CarbonImmutable;

    public function start(): CarbonImmutable;
}
