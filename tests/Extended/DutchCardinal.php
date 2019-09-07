<?php

namespace JosKolenberg\Cardinal\Tests\Extended;

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