<?php

namespace Src\Electricity\Readings\Domain;

use Src\Electricity\Readings\Domain\ValueObjects\ReadingReadingValue;
use Src\Electricity\Readings\Domain\ValueObjects\ReadingPeriod;
use Src\Electricity\Readings\Domain\ValueObjects\ReadingClient;

final class Reading
{
    private int|ReadingReadingValue $readingValue;
    private string|ReadingPeriod $period;
    private string|ReadingClient $client;

    public function __construct(
        int $readingValue,
        string $period,
        string $client
    ) {
        $this->readingValue = $readingValue;
        $this->period = $period;
        $this->client = $client;

        $this->fromPrimitives();
    }

    public function readingValue(): ReadingReadingValue
    {
        return $this->readingValue;
    }

    public function period(): ReadingPeriod
    {
        return $this->period;
    }

    public function client(): ReadingClient
    {
        return $this->client;
    }

    public function toPrimitive(): array
    {
        return [
            'readingValue' => $this->readingValue->value(),
            'period' => $this->period->value(),
            'client' => $this->client->value(),
        ];
    }

    public function fromPrimitives(): void
    {
        $this->readingValue = new ReadingReadingValue($this->readingValue);
        $this->period = new ReadingPeriod($this->period);
        $this->client = new ReadingClient($this->client);
    }
}
