<?php

namespace Src\Electricity\Readings\Infrastructure\Repositories\Csv;

use Src\Electricity\Readings\Domain\Contracts\ReadingImportRepositoryContract;
use Src\Electricity\Readings\Domain\Reading;

class CsvReadingImportRepository implements ReadingImportRepositoryContract
{
    public function import(string $fileUrl): array
    {
        $primitiveCsv = [];
        $file = fopen($fileUrl, "r");

        while (!feof($file)) {
            $row = fgetcsv($file);
            $primitiveCsv[] = $row;
        }

        return $this->formatPrimitiveCsvToReadingArray($primitiveCsv);
    }

    private function formatPrimitiveCsvToReadingArray(array $primitiveCsv): array
    {
        $readings = [];

        foreach ($primitiveCsv as $key => $row) {
            if ($key === 0 || !is_array($row)) {
                continue;
            }

            $readings[] = new Reading($row[2], $row[1], $row[0]);
        }

        return $readings;
    }
}
