<?php

namespace Src\Electricity\Readings\Domain\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Src\Electricity\Readings\Domain\Reading;

interface ReadingRepositoryContract
{
    public function truncate(): void;

    public function store(Reading $reading): bool;

    public function getGroupedByClient(): Collection;
}
