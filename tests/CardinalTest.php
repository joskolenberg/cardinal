<?php

namespace JosKolenberg\Cardinal\Tests;

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

        foreach ($cases as $degrees => $result) {
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(1));
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

        foreach ($cases as $degrees => $result) {
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(2));
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

        foreach ($cases as $degrees => $result) {
            $cardinal = Cardinal::make($degrees);
            $this->assertEquals($result, $cardinal->format(3));
        }
    }

    /**
     * @test
     */
    public function it_can_convert_a_string_into_degrees()
    {
        $cases = [
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
        ];

        foreach ($cases as $string => $result) {
            $cardinal = Cardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees());
        }
    }

    /**
     * @test
     */
    public function it_can_convert_a_fully_written_string_into_degrees()
    {
        $cases = [
            'North' => 0,
            'North-North-East' => 22.5,
            'NORTH East' => 45,
            'East--North-East' => 67.5,
            'East' => 90,
            'EastSouth-East' => 112.5,
            'South-East' => 135,
            'South South East' => 157.5,
            'South' => 180,
            'South-south-West' => 202.5,
            'South=West' => 225,
            'West-South-West' => 247.5,
            'West' => 270,
            'West-North-West' => 292.5,
            'North-West' => 315,
            'North-North-West' => 337.5,
        ];

        foreach ($cases as $string => $result) {
            $cardinal = Cardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees());
        }
    }

    /**
     * @test
     */
    public function it_has_a_getter_for_degrees()
    {
        $cardinal = Cardinal::make('NNE');
        $this->assertEquals(22.5, $cardinal->degrees);
    }

    /** @test */
    public function it_can_format_into_fully_written_directions()
    {
        $cardinal = Cardinal::make(68);
        $this->assertEquals('EAST', $cardinal->format(1, true));

        $cardinal = Cardinal::make(269);
        $this->assertEquals('WEST', $cardinal->format(2, true));
        $cardinal = Cardinal::make(245);
        $this->assertEquals('SOUTHWEST', $cardinal->format(2, true));

        $cardinal = Cardinal::make(359);
        $this->assertEquals('NORTH', $cardinal->format(3, true));
        $cardinal = Cardinal::make(130);
        $this->assertEquals('SOUTHEAST', $cardinal->format(3, true));
        $cardinal = Cardinal::make(23);
        $this->assertEquals('NORTHNORTHEAST', $cardinal->format(3, true));
    }

    /** @test */
    public function it_can_apply_a_custom_divider()
    {
        $cardinal = Cardinal::make(68);
        $this->assertEquals('EAST', $cardinal->format(1, true, '-'));

        $cardinal = Cardinal::make(269);
        $this->assertEquals('WEST', $cardinal->format(2, true, '-'));
        $cardinal = Cardinal::make(245);
        $this->assertEquals('SOUTH-WEST', $cardinal->format(2, true, '-'));

        $cardinal = Cardinal::make(359);
        $this->assertEquals('NORTH', $cardinal->format(3, true, '-'));
        $cardinal = Cardinal::make(130);
        $this->assertEquals('SOUTH-EAST', $cardinal->format(3, true, '-'));
        $cardinal = Cardinal::make(23);
        $this->assertEquals('NORTH-NORTH-EAST', $cardinal->format(3, true, '-'));
    }

    /**
     * @test
     */
    public function it_returns_the_fully_written_direction_when_casted_to_a_string()
    {
        $cardinal = Cardinal::make(315);
        $this->assertEquals('NORTH-WEST', (string) $cardinal);
    }


    /** @test */
    public function it_can_render_a_localized_string()
    {
        $cardinal = Cardinal::make(68);
        $this->assertEquals('East', $cardinal->formatLocalized(1, true));

        $cardinal = Cardinal::make(269);
        $this->assertEquals('West', $cardinal->formatLocalized(2, true));
        $cardinal = Cardinal::make(245);
        $this->assertEquals('South-West', $cardinal->formatLocalized(2, true, '-'));

        $cardinal = Cardinal::make(359);
        $this->assertEquals('North', $cardinal->formatLocalized(3, true));
        $cardinal = Cardinal::make(130);
        $this->assertEquals('South-East', $cardinal->formatLocalized(3, true, '-'));
        $cardinal = Cardinal::make(23);
        $this->assertEquals('North North East', $cardinal->formatLocalized(3, true, ' '));

    }
}
