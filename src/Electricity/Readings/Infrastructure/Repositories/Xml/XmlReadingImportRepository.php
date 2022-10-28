<?php

namespace Src\Electricity\Readings\Infrastructure\Repositories\Xml;

use Src\Electricity\Readings\Domain\Contracts\ReadingImportRepositoryContract;
use Src\Electricity\Readings\Domain\Reading;

class XmlReadingImportRepository implements ReadingImportRepositoryContract
{
    public function import(string $fileUrl): array
    {
        $fileContents = file_get_contents($fileUrl);
        $xml = simplexml_load_string($fileContents);

        return $this->formatPrimitiveXmlToReadingArray($xml);
    }

    private function formatPrimitiveXmlToReadingArray(\SimpleXMLElement $XMLElement): array
    {
        $readings = [];

        for ($x = 0; $x < $XMLElement->reading->count(); $x++) {
            $readings[] = new Reading(
                $XMLElement->reading[$x]->__toString(),
                $XMLElement->reading[$x]->attributes()->period->__toString(),
                $XMLElement->reading[$x]->attributes()->clientID->__toString()
            );
        }

        return $readings;
    }
}
