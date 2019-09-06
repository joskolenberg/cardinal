<?php

namespace JosKolenberg\Jory\Tests;

use JosKolenberg\Cardinal\Cardinal;
use PHPUnit\Framework\TestCase;

class CardinalTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_give_the_right_direction_with_single_precision()
    {
        $cases = [
            '0' => 'N',
            '44.999' => 'N',
            '45' => 'E',
            '90' => 'E',
            '134.999' => 'E',
            '135' => 'S',
            '180' => 'S',
            '224.999' => 'S',
            '225' => 'W',
            '270' => 'W',
            '314.999' => 'W',
            '315' => 'N',
            '359.999' => 'N',
        ];

        foreach ($cases as $degrees => $result){
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(1));
        }
    }

    /**
     * @test
     */
    public function it_can_convert_a_single_precision_string_to_degrees()
    {
        $cases = [
            'N' => 0,
            'E' => 90,
            'S' => 180,
            'W' => 270,
        ];

        foreach ($cases as $string => $result){
            $cardinal = Cardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees);
        }
    }

    /**
     * @test
     */
    public function it_can_give_the_right_direction_with_double_precision()
    {
        $cases = [
            '0' => 'N',
            '22.499' => 'N',
            '22.5' => 'NE',
            '45' => 'NE',
            '67.499' => 'NE',
            '67.5' => 'E',
            '90' => 'E',
            '112.499' => 'E',
            '112.5' => 'SE',
            '135' => 'SE',
            '157.499' => 'SE',
            '157.5' => 'S',
            '180' => 'S',
            '202.499' => 'S',
            '202.5' => 'SW',
            '225' => 'SW',
            '247.499' => 'SW',
            '247.5' => 'W',
            '270' => 'W',
            '292.499' => 'W',
            '292.5' => 'NW',
            '315' => 'NW',
            '337.499' => 'NW',
            '337.5' => 'N',
            '359.999' => 'N',
        ];

        foreach ($cases as $degrees => $result){
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(2));
        }
    }

    /**
     * @test
     */
    public function it_can_convert_a_double_precision_string_to_degrees()
    {
        $cases = [
            'NE' => 45,
            'SE' => 135,
            'SW' => 225,
            'NW' => 315,
        ];

        foreach ($cases as $string => $result){
            $cardinal = Cardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees);
        }
    }

    /**
     * @test
     */
    public function it_can_give_the_right_direction_with_triple_precision()
    {
        $cases = [
            '0' => 'N',
            '11.249' => 'N',
            '11.25' => 'NNE',
            '22.5' => 'NNE',
            '33.749' => 'NNE',
            '33.75' => 'NE',
            '45' => 'NE',
            '56.249' => 'NE',
            '56.25' => 'ENE',
            '67.5' => 'ENE',
            '78.749' => 'ENE',
            '78.75' => 'E',
            '90' => 'E',
            '101.249' => 'E',
            '102.25' => 'ESE',
            '112.5' => 'ESE',
            '123.749' => 'ESE',
            '123.75' => 'SE',
            '135' => 'SE',
            '146.249' => 'SE',
            '146.25' => 'SSE',
            '157.5' => 'SSE',
            '168.749' => 'SSE',
            '168.75' => 'S',
            '180' => 'S',
            '191.249' => 'S',
            '191.25' => 'SSW',
            '202.5' => 'SSW',
            '213.749' => 'SSW',
            '213.75' => 'SW',
            '225' => 'SW',
            '236.249' => 'SW',
            '236.25' => 'WSW',
            '247.5' => 'WSW',
            '258.749' => 'WSW',
            '258.75' => 'W',
            '270' => 'W',
            '281.249' => 'W',
            '281.25' => 'WNW',
            '292.5' => 'WNW',
            '303.749' => 'WNW',
            '303.75' => 'NW',
            '315' => 'NW',
            '326.249' => 'NW',
            '326.25' => 'NNW',
            '337.5' => 'NNW',
            '348.749' => 'NNW',
            '348.75' => 'N',
            '359.999' => 'N',
        ];

        foreach ($cases as $degrees => $result){
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(3));
        }
    }

    /**
     * @test
     */
    public function it_can_convert_a_triple_precision_string_to_degrees()
    {
        $cases = [
            'NNE' => 22.5,
            'ENE' => 67.5,
            'ESE' => 112.5,
            'SSE' => 157.5,
            'SSW' => 202.5,
            'WSW' => 247.5,
            'WNW' => 292.5,
            'NNW' => 337.5,
        ];

        foreach ($cases as $string => $result){
            $cardinal = Cardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees);
        }
    }
}
