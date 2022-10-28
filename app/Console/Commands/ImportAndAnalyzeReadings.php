<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Src\Electricity\Readings\Infrastructure\Controllers\Analyze\ReadingAnalyzeSuspiciousController;
use Src\Electricity\Readings\Infrastructure\Controllers\Import\ReadingImportCsvController;
use Src\Electricity\Readings\Infrastructure\Repositories\Csv\CsvReadingImportRepository;
use Src\Electricity\Readings\Infrastructure\Repositories\Eloquent\EloquentReadingRepository;

class ImportAndAnalyzeReadings extends Command
{
    protected $signature = 'readings:import-analyze {fileName}';

    protected $description = 'Import and analyze readings';

    public function handle()
    {
        $this->importCsv($this->argument('fileName'));
        $results = $this->analyzeReadings();
        $this->printConsoleTable($results);
    }

    private function printConsoleTable(array $results)
    {
        $headers = ['Client', 'Month', 'Suspicious', 'Median'];

        $this->table($headers, $results);
    }

    private function importCsv(string $fileName)
    {
        $importCsv = new ReadingImportCsvController(
            public_path('assets/'.$fileName),
            new CsvReadingImportRepository(),
            new EloquentReadingRepository()
        );

        $importCsv->__invoke();
    }

    private function analyzeReadings(): array
    {
        $analyzeSuspicious = new ReadingAnalyzeSuspiciousController(
            new EloquentReadingRepository()
        );

        return $analyzeSuspicious->__invoke();
    }
}
