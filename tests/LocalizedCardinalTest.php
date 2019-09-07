<?php

namespace JosKolenberg\Jory\Tests;

use JosKolenberg\Cardinal\Cardinal;
use JosKolenberg\Cardinal\Tests\Extended\DutchCardinal;
use PHPUnit\Framework\TestCase;

class LocalizedCardinalTest extends TestCase
{
    /** @test */
    public function it_still_uses_the_system_values_to_make_objects()
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
            $cardinal = DutchCardinal::make($string);
            $this->assertEquals($result, $cardinal->degrees());
        }
    }

    /** @test */
    public function it_can_be_overridden_to_insert_locale_settings()
    {
        $cardinal = DutchCardinal::make(90);
        $this->assertEquals('O', $cardinal->formatLocalized(1));

        $cardinal = DutchCardinal::make(180);
        $this->assertEquals('Z', $cardinal->formatLocalized(2));
        $cardinal = DutchCardinal::make(45);
        $this->assertEquals('N-O', $cardinal->formatLocalized(2, false, '-'));

        $cardinal = DutchCardinal::make(269);
        $this->assertEquals('W', $cardinal->formatLocalized(3));
        $cardinal = DutchCardinal::make(160);
        $this->assertEquals('ZZO', $cardinal->formatLocalized(3));
        $cardinal = DutchCardinal::make(220);
        $this->assertEquals('Z W', $cardinal->formatLocalized(3, false, ' '));

        $cardinal = DutchCardinal::make(68);
        $this->assertEquals('Oost', $cardinal->formatLocalized(1, true));

        $cardinal = DutchCardinal::make(269);
        $this->assertEquals('West', $cardinal->formatLocalized(2, true));
        $cardinal = DutchCardinal::make(245);
        $this->assertEquals('Zuid-West', $cardinal->formatLocalized(2, true, '-'));

        $cardinal = DutchCardinal::make(359);
        $this->assertEquals('Noord', $cardinal->formatLocalized(3, true));
        $cardinal = DutchCardinal::make(130);
        $this->assertEquals('Zuid-Oost', $cardinal->formatLocalized(3, true, '-'));
        $cardinal = DutchCardinal::make(23);
        $this->assertEquals('Noord Noord Oost', $cardinal->formatLocalized(3, true, ' '));
    }
}
