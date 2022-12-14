# Timeslot reservation management using PHP

> **Currently being developed**. Development started on 08-05-2022.

> ## Requirements
> PHP 8.1

---
**Timeslot** uses [Carbon](https://github.com/briannesbitt/Carbon) to manage dates and times.
You can create a new timeslot passing it a Carbon instance, a DateTime instance or a valid datetime string instead.
The complete syntax is `new Timeslot($start, $hours, $minutes)`. Fluent methods, getters and setters are available as well.

## Examples
```php
// Create a 30-minutes timeslot from a string starting at 15:00
$timeslot = new Timeslot('2017-08-19 15:00:00', 0, 30);

// Get its start and end time as datetime strings (Carbon)
$timeslot->start()->toDateTimeString(); // 2017-08-19 15:00:00
$timeslot->end()->toDateTimeString();   // 2017-08-19 15:29:59

// Create a TimeslotCollection based on the $timeslot, containing 4 timeslots
$collection = TimeslotCollection::create($timeslot, 4);

// A TimeslotCollection has a start and end time as well...
$collection->start()->toDateTimeString(); // 2017-08-19 15:00:00
$collection->end()->toDateTimeString();   // 2017-08-19 16:59:59 (2 hours later)

// ...and you can get the single timeslots if you want.
$collection->get(1)->start()->toDateTimeString(); // 2017-08-19 15:30:00 (second timeslot in the collection)
```
_[original documentation](https://github.com/gpaddis/timeslot)_

## Installation

You can install the package via composer:

```bash
composer require jhavenz/php-reservables
```

## Usage

```php
/// TO DO
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
> This package is inspired by [this timeslot package](https://github.com/gpaddis/timeslot).
> Being that their package hasn't been updated in years (as of Sep-2022), and seeing places for improvement, I decided to create my own.

- [Jonathan Havens](https://github.com/jhavenz)
- [Original Package](https://github.com/gpaddis/timeslot)
- [Carbon](https://github.com/briannesbitt/Carbon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
