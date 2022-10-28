<?php

namespace Tests\Unit\Electricity\Readings\Application\Analyze;

use Src\Electricity\Readings\Domain\Contracts\ReadingRepositoryContract;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Electricity\Readings\Application\Domain\ReadingMother;

class ReadingAnalyzeSuspiciousUseCaseUnitTest extends TestCase
{
    public function test_should_call_truncate()
    {
        $readingRepositoryMock = $this->createMock(ReadingRepositoryContract::class);

        $readingRepositoryMock->expects(self::once())
            ->method('truncate');

        $readingRepositoryMock->truncate();
    }

    public function test_should_store_reading()
    {
        $readingRepositoryMock = $this->createMock(ReadingRepositoryContract::class);

        $reading = ReadingMother::create(1234, '2020-01-01', 'client1');

        $readingRepositoryMock->expects(self::once())->method('store');
        $readingRepositoryMock->store($reading);
    }
}
