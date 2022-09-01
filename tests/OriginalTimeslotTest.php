<?php
# The tests from the original package

it ('creates a timeslot from a Datetime instance', function () {
    $datetime = new DateTime('2010-04-24 10:24:16');
    $timeslot = Timeslot::create($datetime)->round();

    $this->assertEquals('2010-04-24 10:00:00', $timeslot->start()->toDateTimeString());
    $this->assertEquals('2010-04-24 10:59:59', $timeslot->end()->toDateTimeString());
});

it ('it creates a timeslot from a string');
it ('it creates a default timeslot when no arguments are passed');
it ('carbon throws an exception if the string cannot be parsed');
it ('it throws an exception if an invalid argument is passed');
it ('now timeslot is a rounded timeslot');
it ('it rounds a timeslot that spans many hours');
it ('it creates a 30 m timeslot');
it ('a timeslot can start at anytime');
it ('it returns the following timeslot');
it ('external manipulation of start and end instances does not affect the timeslot');
it ('it checks whether a datetime object is within the timeslot');
