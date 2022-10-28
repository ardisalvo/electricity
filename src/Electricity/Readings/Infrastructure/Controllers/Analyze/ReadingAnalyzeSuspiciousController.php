<?php

namespace Src\Electricity\Readings\Infrastructure\Controllers\Analyze;

use Src\Electricity\Readings\Application\Analyze\ReadingAnalyzeSuspiciousUseCase;
use Src\Electricity\Readings\Infrastructure\Repositories\Eloquent\EloquentReadingRepository;

class ReadingAnalyzeSuspiciousController
{
    private ReadingAnalyzeSuspiciousUseCase $useCase;
    private EloquentReadingRepository $eloquentRepository;

    public function __construct(
        EloquentReadingRepository $eloquentRepository,
    ) {
        $this->eloquentRepository = $eloquentRepository;
        $this->useCase = new ReadingAnalyzeSuspiciousUseCase($this->eloquentRepository);
    }

    public function __invoke()
    {
        return $this->useCase->__invoke();
    }
}
