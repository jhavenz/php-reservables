<?php

use Jhavenz\PhpTimeslotReservations\TimeslotCollection;

it('it only allows instances of ITimeslot', function ($invalidTimeslot) {
    expect(TimeslotCollection::make([$invalidTimeslot]));
})->with('invalid_timeslots')->expectException(InvalidArgumentException::class);
