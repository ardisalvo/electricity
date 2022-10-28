<?php

namespace Tests\Unit\Electricity\Readings\Application\Domain;

use Src\Electricity\Readings\Domain\Reading;

class ReadingMother
{
    public static function create(
        int $readingValue,
        string $period,
        string $client
    ): Reading {
        return new Reading($readingValue, $period, $client);
    }
}
