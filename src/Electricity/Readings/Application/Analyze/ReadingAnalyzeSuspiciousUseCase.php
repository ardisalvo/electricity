<?php

namespace Src\Electricity\Readings\Application\Analyze;

use Illuminate\Database\Eloquent\Collection;
use Src\Electricity\Readings\Domain\Contracts\ReadingRepositoryContract;

class ReadingAnalyzeSuspiciousUseCase
{
    private ReadingRepositoryContract $repository;

    public function __construct(ReadingRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        $readingsGroupedByClient = $this->repository->getGroupedByClient();
        $suspiciousReadings = [];

        foreach ($readingsGroupedByClient as $readings) {
            $readingMedian = $readings->avg('reading_value') * 1.5;
            $filteredReadings = $this->filterSuspiciousReadings($readings, $readingMedian);
            $formattedReadings[] = $this->formatReadings($filteredReadings);
            $suspiciousReadings = $this->formatResponse($formattedReadings);
        }

        return $suspiciousReadings;
    }

    private function filterSuspiciousReadings(Collection $readings, int $readingMedian): array
    {
        $filteredReadings = [];

        foreach ($readings as $key => $reading) {
            if ($reading->reading_value > $readingMedian) {
                $readings[$key]['median'] = $readingMedian;

                $filteredReadings[] = $reading;
            }
        }

        return $filteredReadings;
    }

    private function formatReadings(array $readings): array
    {
        $formattedReadings = [];

        foreach ($readings as $reading) {
            $formattedReadings[] = [
                'client' => $reading->client,
                'period' => $reading->period,
                'value' => $reading->reading_value,
                'median' => $reading->median,
            ];
        }

        return $formattedReadings;
    }

    private function formatResponse(array $formattedReadings): array
    {
        $suspiciousReadings = [];

        foreach ($formattedReadings as $reading) {
            foreach ($reading as $item) {
                $suspiciousReadings[] = $item;
            }
        }

        return $suspiciousReadings;
    }
}
