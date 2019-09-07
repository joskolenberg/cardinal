[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/joskolenberg/cardinal/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/joskolenberg/cardinal/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/joskolenberg/cardinal/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/joskolenberg/cardinal/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/joskolenberg/cardinal/badges/build.png?b=master)](https://scrutinizer-ci.com/g/joskolenberg/cardinal/build-status/master)
[![Total Downloads](https://poser.pugx.org/joskolenberg/cardinal/downloads)](https://packagist.org/packages/joskolenberg/cardinal)
[![Latest Stable Version](https://poser.pugx.org/joskolenberg/cardinal/v/stable)](https://packagist.org/packages/joskolenberg/cardinal)
[![License](https://poser.pugx.org/joskolenberg/cardinal/license)](https://packagist.org/packages/joskolenberg/cardinal)

# Cardinal
Little wrapper object to handle cardinal directions.

## Installation
```
composer require joskolenberg/cardinal
```

## Examples
Create object with degrees (0 to 359.999) and format into string.
```php
Cardinal::make(45)->format() // => 'NE'
```

Use precision parameter to be more or less precise.
```php
Cardinal::make(66)->format(1) // => 'E'
Cardinal::make(66)->format(2) // => 'NE'
Cardinal::make(66)->format(3) // => 'ENE'
```

Use second and third parameter to switch to fully written directions with divider.
```php
Cardinal::make(250)->format(3, true, '-') // => 'WEST-SOUTH-WEST'
```

Create object from string (with or without any divider) and return degrees.
```php
Cardinal::make('NNW')->degrees // => 337.5
Cardinal::make('South-West')->degrees // => 225
Cardinal::make('West NorthWest')->degrees // => 292.5
```

Use ```formatLocalized()``` to get localized string
```php
Cardinal::make(250)->formatLocalized(3, true, '-') // => 'West-South-West'
```

Override ```lang()``` to create your own localization
```php
use JosKolenberg\Cardinal\Cardinal;

class DutchCardinal extends Cardinal
{
    protected function lang(): array
    {
        return [
            'N' => 'N',
            'E' => 'O',
            'S' => 'Z',
            'W' => 'W',
            'NORTH' => 'Noord',
            'EAST' => 'Oost',
            'SOUTH' => 'Zuid',
            'WEST' => 'West',
        ];
    }
}
```
```php
Cardinal::make(157.5)->formatLocalized(3, true, '-') // => 'Zuid-Zuid-Oost'
```

Or integrate with localization in your framework. E.g. Laravel:
```php
use JosKolenberg\Cardinal\Cardinal;

class LocalizedCardinal extends Cardinal
{
    protected function lang(): array
    {
        return [
            'N' => __('app.cardinal.n'),
            'E' => __('app.cardinal.e'),
            'S' => __('app.cardinal.s'),
            'W' => __('app.cardinal.w'),
            'NORTH' => __('app.cardinal.north'),
            'EAST' => __('app.cardinal.east'),
            'SOUTH' => __('app.cardinal.south'),
            'WEST' => __('app.cardinal.west'),
        ];
    }
}
```



That's it! Any suggestions or issues? Please contact me!

Happy coding!

Jos Kolenberg <jos@kolenberg.net>