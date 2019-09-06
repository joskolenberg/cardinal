<?php

namespace JosKolenberg\Cardinal;

/**
 * Class Cardinal
 *
 * @package JosKolenberg\Cardinal
 * @property-read degrees
 */
class Cardinal
{

    protected $degrees = 0;

    public function __construct($direction)
    {
        if(is_numeric($direction)){
            $this->degrees = $direction;

            return;
        }

        $this->degrees = $this->convertStringToDegrees($direction);
    }

    public static function make($direction)
    {
        return new self($direction);
    }

    public function format(int $precision = 2)
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

    public function degrees()
    {
        return $this->degrees;
    }

    public function __toString()
    {
        return $this->formatLong(2);
    }

    public function __get($name)
    {
        if($name === 'degrees'){
            return $this->degrees;
        }
    }

    public function lang()
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

    protected function formatSingle()
    {
        $values = [
            'N',
            'E',
            'S',
            'W',
        ];

        for ($i = 0; $i < 3; $i++){
            $min = $this->getRangeMin($i, 90);
            $max = $this->getRangeMax($i, 90);

            if($this->inRange($min, $max)){
                break;
            }
        }
        return $values[$i];
    }

    protected function formatDouble()
    {
        $values = [
            'N',
            'NE',
            'E',
            'SE',
            'S',
            'SW',
            'W',
            'NW',
        ];

        for ($i = 0; $i < 7; $i++){
            $min = $this->getRangeMin($i, 45);
            $max = $this->getRangeMax($i, 45);

            if($this->inRange($min, $max)){
                break;
            }
        }
        return $values[$i];
    }

    protected function formatTriple()
    {
        $values = [
            'N',
            'NNE',
            'NE',
            'ENE',
            'E',
            'ESE',
            'SE',
            'SSE',
            'S',
            'SSW',
            'SW',
            'WSW',
            'W',
            'WNW',
            'NW',
            'NNW',
        ];

        for ($i = 0; $i < 15; $i++){
            $min = $this->getRangeMin($i, 22.5);
            $max = $this->getRangeMax($i, 22.5);

            if($this->inRange($min, $max)){
                break;
            }
        }
        return $values[$i];
    }

    protected function convertStringToDegrees(string $direction)
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

    public function formatLong(int $precision = 2)
    {
    }

    protected function getRangeMin(int $pieceOfPieIndex, float $pieceOfPieSize)
    {
        if($pieceOfPieIndex === 0){
            return 360 - ($pieceOfPieSize / 2);
        }

        return ($pieceOfPieIndex * $pieceOfPieSize) - ($pieceOfPieSize / 2);
    }

    protected function getRangeMax(int $pieceOfPieIndex, float $pieceOfPieSize)
    {
        return ($pieceOfPieIndex * $pieceOfPieSize) + ($pieceOfPieSize / 2);
    }

    protected function inRange(float $min, float $max)
    {
        if($min > $max){
            return ($this->degrees >= $min || $this->degrees < $max);
        }

        if($this->degrees >= $min && $this->degrees < $max){
            return true;
        }

        return false;

    }
}