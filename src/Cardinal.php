<?php

namespace JosKolenberg\Cardinal;

/**
 * Class Cardinal
 *
 * @property-read float degrees
 */
class Cardinal
{
    /**
     * @var float
     */
    protected $degrees = 0;

    /**
     * Cardinal constructor.
     *
     * @param $direction
     */
    public function __construct($direction)
    {
        if(is_numeric($direction)){
            $this->degrees = (float) $direction;

            return;
        }

        $this->degrees = (float) $this->convertStringToDegrees($direction);
    }

    /**
     * Make a new Cardinal instance.
     *
     * @param $direction
     * @return \JosKolenberg\Cardinal\Cardinal
     */
    public static function make($direction): self
    {
        return new static($direction);
    }

    /**
     * Format the Cardinal into e.g. 'N', 'NE', 'SSW', etc.
     *
     * Use the $full and $divider parameter to convert
     * to fully written directions. E.g. 'NORTH-WEST'.
     *
     * @param int $precision
     * @param bool $full
     * @param string $divider
     * @return string
     */
    public function format(int $precision = 2, bool $full = false, string $divider = ''): string
    {
        if($full){
            return implode($divider, $this->arrayToFull($this->formatToArray($precision)));
        }

        return implode($divider, $this->formatToArray($precision));
    }

    /**
     * Localized counterpart of format().
     *
     * Override lang() method to adjust to localization.
     *
     * @param int $precision
     * @param bool $full
     * @param string $divider
     * @return string
     */
    public function formatLocalized(int $precision = 2, bool $full = false, string $divider = ''): string
    {
        if($full){
            return implode($divider, $this->translateArray($this->arrayToFull($this->formatToArray($precision))));
        }

        return implode($divider, $this->translateArray($this->formatToArray($precision)));
    }

    /**
     * Get the number of degrees.
     *
     * @return float
     */
    public function degrees(): float
    {
        return $this->degrees;
    }

    /**
     * Convert to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->format(2, true, '-');
    }

    /**
     * Make degrees property read-only available.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if($name === 'degrees'){
            return $this->degrees;
        }
    }

    /**
     * Define the language array.
     * Override to adjust to your own language.
     *
     * @return array
     */
    protected function lang(): array
    {
        return [
            'N' => 'N',
            'E' => 'E',
            'S' => 'S',
            'W' => 'W',
            'NORTH' => 'North',
            'EAST' => 'East',
            'SOUTH' => 'South',
            'WEST' => 'West',
        ];
    }

    /**
     * Format into a single precision array with letter; e.g. ['N'], ['E'], ['S'] or ['W'].
     *
     * @return array
     */
    protected function formatSingle(): array
    {
        $values = [
            ['N'],
            ['E'],
            ['S'],
            ['W'],
        ];

        for ($i = 0; $i < 3; $i++){
            $min = $this->getRangeMin($i, 360/4);
            $max = $this->getRangeMax($i, 360/4);

            if($this->inRange($min, $max)){
                break;
            }
        }

        return $values[$i];
    }

    /**
     * Format into double precision array of letters; e.g. ['N', 'N','E'], ['E'], ['S','E'], etc.
     *
     * @return array
     */
    protected function formatDouble(): array
    {
        $values = [
            ['N'],
            ['N','E'],
            ['E'],
            ['S','E'],
            ['S'],
            ['S','W'],
            ['W'],
            ['N','W'],
        ];

        for ($i = 0; $i < 7; $i++){
            $min = $this->getRangeMin($i, 360/8);
            $max = $this->getRangeMax($i, 360/8);

            if($this->inRange($min, $max)){
                break;
            }
        }

        return $values[$i];
    }

    /**
     * Format into triple precision array of letters; e.g. ['N'], ['N','N','E'], ['N','E'], ['E','N','E'], etc.
     *
     * @return array
     */
    protected function formatTriple(): array
    {
        $values = [
            ['N'],
            ['N','N','E'],
            ['N','E'],
            ['E','N','E'],
            ['E'],
            ['E','S','E'],
            ['S','E'],
            ['S','S','E'],
            ['S'],
            ['S','S','W'],
            ['S','W'],
            ['W','S','W'],
            ['W'],
            ['W','N','W'],
            ['N','W'],
            ['N','N','W'],
        ];

        for ($i = 0; $i < 15; $i++){
            $min = $this->getRangeMin($i, 360/16);
            $max = $this->getRangeMax($i, 360/16);

            if($this->inRange($min, $max)){
                break;
            }
        }

        return $values[$i];
    }

    /**
     * Get the number of degrees out of a string.
     * E.g. 'E' = 90, 'North-North-East = 22.5, etc.
     *
     * @param string $direction
     * @return float
     */
    protected function convertStringToDegrees(string $direction): float
    {
        $direction = strtoupper($direction);

        $sanitizedString = '';

        $search = [
            'NORTH' => 'N',
            'EAST' => 'E',
            'SOUTH' => 'S',
            'WEST' => 'W',
            'N' => 'N',
            'E' => 'E',
            'S' => 'S',
            'W' => 'W',
        ];

        while ($direction != ''){
            $found = false;

            foreach ($search as $string => $letter) {
                if(substr($direction, 0, strlen($string)) === $string){
                    $direction = substr($direction, strlen($string));
                    $sanitizedString .= $letter;
                    $found = true;
                    break;
                }
            }

            if(!$found){
                $direction = substr($direction, 1);
            }
        }

        return $this->convertSanitizedStringToDegrees($sanitizedString);
    }

    /**
     * Get the number of degrees out of a sanitized string. e.g. 'E' = 90.
     *
     * @param string $direction
     * @return float
     */
    protected function convertSanitizedStringToDegrees(string $direction): float
    {
        return [
            'N' => 0,
            'NNE' => 22.5,
            'NE' => 45,
            'ENE' => 67.5,
            'E' => 90,
            'ESE' => 112.5,
            'SE' => 135,
            'SSE' => 157.5,
            'S' => 180,
            'SSW' => 202.5,
            'SW' => 225,
            'WSW' => 247.5,
            'W' => 270,
            'WNW' => 292.5,
            'NW' => 315,
            'NNW' => 337.5,
        ][$direction];
    }

    /**
     * Get the degree at which a range starts. Given the size of
     * a single part of the compass and the index of a range.
     * North always being index 0 and counting clock-wise.
     *
     * @param int $pieceOfPieIndex
     * @param float $pieceOfPieSize
     * @return float
     */
    protected function getRangeMin(int $pieceOfPieIndex, float $pieceOfPieSize): float
    {
        if($pieceOfPieIndex === 0){
            return 360 - ($pieceOfPieSize / 2);
        }

        return ($pieceOfPieIndex * $pieceOfPieSize) - ($pieceOfPieSize / 2);
    }

    /**
     * Max counterpart of getRangeMin.
     *
     * @param int $pieceOfPieIndex
     * @param float $pieceOfPieSize
     * @return float
     */
    protected function getRangeMax(int $pieceOfPieIndex, float $pieceOfPieSize): float
    {
        return ($pieceOfPieIndex * $pieceOfPieSize) + ($pieceOfPieSize / 2);
    }

    /**
     * Check if the degrees fall into the given min/max range.
     *
     * @param float $min
     * @param float $max
     * @return bool
     */
    protected function inRange(float $min, float $max) :bool
    {
        if($min > $max){
            return ($this->degrees >= $min || $this->degrees < $max);
        }

        if($this->degrees >= $min && $this->degrees < $max){
            return true;
        }

        return false;

    }

    /**
     * Format the degrees into an array of single letters
     * which can be translated into a string.
     *
     * E.g. 23 degrees with triple precision returns ['N', 'N', 'E'] for 'NNE'.
     *
     * @param int $precision
     * @return array
     */
    protected function formatToArray(int $precision): array
    {
        switch ($precision){
            case 1:
                return $this->formatSingle();
            case 3:
                return $this->formatTriple();
            case 2:
            default:
                return $this->formatDouble();
        }
    }

    /**
     * Translate an array of directions.
     *
     * E.g. ['N', 'E'] => ['N', 'E']
     * or ['NORTH'] => ['North']
     *
     * @param array $directions
     * @return array
     */
    protected function translateArray(array $directions): array
    {
        return array_map([$this, 'translateSingle'], $directions);
    }

    /**
     * Translate a single direction into a localized string.
     *
     * @param string $direction
     * @return string
     */
    protected function translateSingle(string $direction): string
    {
        return $this->lang()[$direction];
    }

    /**
     * Convert an array with single letter directions
     * to fully written directions.
     *
     * E.g. ['N', 'E'] => ['NORTH', 'EAST']
     *
     * @param array $directions
     * @return array
     */
    protected function arrayToFull(array $directions): array
    {
        return array_map(function ($item){
            return [
                'N' => 'NORTH',
                'E' => 'EAST',
                'S' => 'SOUTH',
                'W' => 'WEST',
            ][$item];
        }, $directions);
    }
}