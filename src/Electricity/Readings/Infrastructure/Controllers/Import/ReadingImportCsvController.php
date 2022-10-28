<?php

namespace Src\Electricity\Readings\Infrastructure\Controllers\Import;

use Illuminate\Http\Response;
use Src\Electricity\Readings\Application\Import\ReadingImportUseCase;
use Src\Electricity\Readings\Domain\Contracts\ReadingImportRepositoryContract;
use Src\Electricity\Readings\Infrastructure\Repositories\Csv\CsvReadingImportRepository;
use Src\Electricity\Readings\Infrastructure\Repositories\Eloquent\EloquentReadingRepository;

class ReadingImportCsvController
{
    private ReadingImportUseCase $useCase;
    private ReadingImportRepositoryContract $repositoryImport;
    private EloquentReadingRepository $eloquentRepository;
    private string $csvName;

    public function __construct(
        string $csvName,
        CsvReadingImportRepository $repositoryImport,
        EloquentReadingRepository $eloquentRepository,
    ) {
        $this->csvName = $csvName;
        $this->repositoryImport = $repositoryImport;
        $this->eloquentRepository = $eloquentRepository;
        $this->useCase = new ReadingImportUseCase($this->repositoryImport, $this->eloquentRepository);
    }

    public function __invoke(): Response
    {
        return $this->useCase->__invoke($this->csvName);
    }
}
