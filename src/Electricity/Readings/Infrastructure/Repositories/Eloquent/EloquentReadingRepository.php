<?php

namespace Src\Electricity\Readings\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Src\Electricity\Readings\Domain\Contracts\ReadingRepositoryContract;
use Src\Electricity\Readings\Domain\Reading;

class EloquentReadingRepository implements ReadingRepositoryContract
{
    public function truncate(): void
    {
        EloquentReadingModel::truncate();
    }

    public function store(Reading $reading): bool
    {
        $result = EloquentReadingModel::create([
            'reading_value' => $reading->readingValue()->value(),
            'period' => $reading->period()->value(),
            'client' => $reading->client()->value(),
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    public function getGroupedByClient(): Collection
    {
        return EloquentReadingModel::select('client', 'period', 'reading_value')
            ->orderBy('client')
            ->orderBy('period')
            ->get()
            ->groupBy('client');
    }
}
