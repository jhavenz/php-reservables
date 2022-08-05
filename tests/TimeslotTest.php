<?php

use Jhavenz\PhpTimeslotReservations\Timeslot;

it('can be created with correct start and end', function () {
    $timeslot = new Timeslot('2022-08-05 10:00:00', 2, 30);

    expect($timeslot->start()->format(DATE_ATOM))
        ->toEqual('2022-08-05T10:00:00+00:00')
        ->and($timeslot->end()->format(DATE_ATOM))
        ->toEqual('2022-08-05T12:29:59+00:00');
});
