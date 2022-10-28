<?php

namespace Src\Electricity\Readings\Infrastructure\Controllers\Import;

use Illuminate\Http\Response;
use Src\Electricity\Readings\Application\Import\ReadingImportUseCase;
use Src\Electricity\Readings\Infrastructure\Repositories\Eloquent\EloquentReadingRepository;
use Src\Electricity\Readings\Infrastructure\Repositories\Xml\XmlReadingImportRepository;

class ReadingImportXmlController
{
    private ReadingImportUseCase $useCase;
    private XmlReadingImportRepository $repositoryImport;
    private EloquentReadingRepository $eloquentRepository;
    private string $csvName;

    public function __construct(
        string $csvName,
        XmlReadingImportRepository $repositoryImport,
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
