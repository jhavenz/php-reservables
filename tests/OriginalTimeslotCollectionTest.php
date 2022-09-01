<?php
# The tests from the original package

use Jhavenz\PhpTimeslotReservations\Timeslot;
use Jhavenz\PhpTimeslotReservations\TimeslotCollection;

it ('it has the same start and end time of the timeslot contained', function () {
    $timeslot = Timeslot::now();
    $timeslotCollection = new TimeslotCollection($timeslot);

    $this->assertEquals($timeslot->start(), $timeslotCollection->start());
    $this->assertEquals($timeslot->end(), $timeslotCollection->end());
});

it ('it updates the collection each time a new timeslot is added', function () {
    $timeslot1 = Timeslot::create('2017-02-11 10:00:00');
    $timeslot2 = Timeslot::create('2017-02-11 11:00:00');
    $timeslot3 = Timeslot::create('2017-02-11 09:00:00');
    $timeslot4 = Timeslot::create('2017-02-11 05:00:00');

    $collection = new TimeslotCollection($timeslot1);
    $collection->add($timeslot2);
    $collection->add($timeslot3);

    // Add a nested timeslot to $collection
    $collection->add(TimeslotCollection::create($timeslot4, 4));

    $this->assertEquals('2017-02-11 05:00:00', $collection->start()->toDateTimeString());
    $this->assertEquals('2017-02-11 11:59:59', $collection->end()->toDateTimeString());
});

it ('it sorts a timeslot collection');
it ('it generates a collection of timeslots');
it ('it removes a timeslot from a collection');
it ('it cannot remove all timeslots from a collection');
it ('it can contain a collection of timeslots');
it ('it throws an exception if the offset is undefined');
it ('it throws an exception if the timeslot already exists in the collection');
