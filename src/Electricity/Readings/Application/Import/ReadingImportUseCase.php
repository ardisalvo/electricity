<?php

namespace Src\Electricity\Readings\Application\Import;

use Src\Electricity\Readings\Domain\Contracts\ReadingImportRepositoryContract;
use Src\Electricity\Readings\Domain\Contracts\ReadingRepositoryContract;
use Illuminate\Http\Response;
use Src\Electricity\Readings\Domain\Exceptions\ReadingException;

class ReadingImportUseCase
{
    private ReadingImportRepositoryContract $importRepository;
    private ReadingRepositoryContract $repository;

    public function __construct(
        ReadingImportRepositoryContract $importRepository,
        ReadingRepositoryContract $repository,
    ) {
        $this->importRepository = $importRepository;
        $this->repository = $repository;
    }


    public function __invoke(string $fileUrl): Response
    {
        $importedReadings = $this->importRepository->import($fileUrl);
        $this->repository->truncate();

        foreach ($importedReadings as $reading) {
            $this->repository->store($reading);
        }

        return response([
            'message' => 'Readings imported successfully',
        ], 200);
    }
}
