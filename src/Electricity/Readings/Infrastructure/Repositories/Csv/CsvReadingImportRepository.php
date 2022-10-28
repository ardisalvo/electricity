<?php

namespace Src\Electricity\Readings\Infrastructure\Repositories\Csv;

use Src\Electricity\Readings\Domain\Contracts\ReadingImportRepositoryContract;
use Src\Electricity\Readings\Domain\Exceptions\ReadingException;
use Src\Electricity\Readings\Domain\Reading;

class CsvReadingImportRepository implements ReadingImportRepositoryContract
{
    public function import(string $fileUrl): array
    {
        if (!file_exists($fileUrl)) {
            throw new ReadingException('File not found', 404);
        }

        if (filesize($fileUrl) > (2048 * 1024)) {
            throw new ReadingException('The file is too large. Maximum 2MB.', 500);
        }

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
