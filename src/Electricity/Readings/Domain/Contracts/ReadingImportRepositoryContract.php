<?php

namespace Src\Electricity\Readings\Domain\Contracts;

interface ReadingImportRepositoryContract
{
    public function import(string $fileUrl): array;
}
