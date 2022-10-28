<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Src\Electricity\Readings\Domain\Exceptions\ReadingException;
use Src\Electricity\Readings\Infrastructure\Controllers\Analyze\ReadingAnalyzeSuspiciousController;
use Src\Electricity\Readings\Infrastructure\Controllers\Import\ReadingImportCsvController;
use Src\Electricity\Readings\Infrastructure\Repositories\Eloquent\EloquentReadingRepository;

class ImportAndAnalyzeReadings extends Command
{
    protected $signature = 'readings:import-analyze {fileName}';

    protected $description = 'Import and analyze readings';

    /**
     * @throws ReadingException
     */
    public function handle()
    {
        $fileName = $this->argument('fileName');
        $controllerClassName = $this->getControllerRepositoryClassName($fileName);
        $repositoryClassName = $this->getImporterRepositoryClassName($fileName);

        $this->importFromFile($fileName, $controllerClassName, $repositoryClassName);
        $results = $this->analyzeReadings();
        $this->printConsoleTable($results);
    }

    private function getImporterRepositoryClassName(string $fileName): string
    {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $className = 'Src\Electricity\Readings\Infrastructure\Repositories\\'.ucfirst($fileExtension).'\\'.ucfirst($fileExtension).'ReadingImportRepository';

        if (!class_exists($className)) {
            throw new ReadingException("It is not possible to import files of this type. Repository not found.", 500);
        }

        return $className;
    }

    private function getControllerRepositoryClassName(string $fileName): string
    {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $className = 'Src\Electricity\Readings\Infrastructure\Controllers\Import\\ReadingImport'.ucfirst($fileExtension).'Controller';

        if (!class_exists($className)) {
            throw new ReadingException("It is not possible to import files of this type. Controller not found.", 500);
        }

        return $className;
    }

    private function printConsoleTable(array $results)
    {
        $headers = ['Client', 'Month', 'Suspicious', 'Median'];

        $this->table($headers, $results);
    }

    private function importFromFile(string $fileName, string $controllerClassName, string $repositoryClassName)
    {
        $importCsv = new $controllerClassName(
            public_path('assets/'.$fileName),
            new $repositoryClassName(),
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
