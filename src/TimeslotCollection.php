<?php

namespace Jhavenz\PhpTimeslotReservations;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTimeInterface;
use Exception;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Jhavenz\CarbonHelpers\CarbonCollection;
use OutOfRangeException;

use function Jhavenz\CarbonHelpers\carbonImmutable;

/**
 * @implements Collection<array-key, ITimeslot>
 */
class TimeslotCollection extends Collection
{
    public function add($item): static
    {
        if ( ! $item instanceof ITimeslot) {
            throw new InvalidArgumentException('Timeslot collections only accept instances of ITimeslot');
        }

        return parent::add($item);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public static function create(
        ?ITimeslot $timeslot = null,
        int $quantity = 0,
        ?CarbonInterval $duration = new CarbonInterval(hours: 1)
    ): static {
        $collection = static::make();

        $timeslot && $collection
            ->add($timeslot)
            ->when($quantity, function (TimeslotCollection $timeslots, $qty) use ($duration, $timeslot) {
                foreach (range(1, $qty) as $_) {
                    $timeslots[] = $timeslot = Timeslot::after($timeslot, $duration);
                }
            });

        return $collection;
    }

    public function end(): Carbon
    {
        return $this->sortByStartTime()->end();
    }

    public function findByEndingTimestamp(DateTimeInterface|string|int $when, bool $orFail = false): ?ITimeslot
    {
        return $this->findByTimestamp($when, 'end',  $orFail);
    }

    public function findByStartingTimestamp(DateTimeInterface|string|int $when, bool $orFail = false): ?ITimeslot
    {
        return $this->findByTimestamp($when, orFail: $orFail);
    }

    protected function findByTimestamp(DateTimeInterface|string|int $when, string $timeslotAttribute = 'start', bool $orFail = false): ?ITimeslot
    {
        $method = $orFail ? 'firstOrFail' : 'first';

        $when = carbonImmutable($when);

        return $this->{$method}(fn (ITimeslot $timeslot) => $timeslot->{$timeslotAttribute}()->getTimestamp() === $when->getTimestamp());
    }

    protected function getArrayableItems($items): array
    {
        $this->items = parent::getArrayableItems($items);

        foreach ($items as $item) {
            if (! $item instanceof ITimeslot) {
                throw new InvalidArgumentException('Timeslot collection can only contain implementations of the ITimeslot contract');
            }
        }

        return $this->items;
    }

    public function get($key, $default = null): mixed
    {
        if ($value = parent::get($key)) {
            return $value;
        }

        if(CarbonCollection::wrap($key)->isEmpty()) {
            return value($default);
        }

        return $this->findByStartingTimestamp(carbonImmutable($key));
    }

    /**
     * Remove a Timeslot from the collection.
     *
     * @param  int  $offset
     * @return this
     */
    public function remove(int $offset)
    {
        if (!array_key_exists($offset, $this->collection)) {
            throw new OutOfRangeException('The offset does not exist in this collection.');
        }

        if (count($this->collection) <= 1) {
            throw new Exception('You cannot remove all timeslots in a collection.');
        }

        unset($this->collection[$offset]);

        $this->sort();
    }

    public function sortByEndTime(): static
    {
        return $this->sortBy(fn(ITimeslot $timeslot) => $timeslot->end()->getTimestamp());
    }

    public function sortByStartTime(): static
    {
        return $this->sortBy(fn(ITimeslot $timeslot) => $timeslot->start()->getTimestamp());
    }

    public function start(): Carbon
    {
        return $this->sortByStartTime()->first();
    }
}
