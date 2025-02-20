<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Enums\SpreadsheetExportFormat;
use Illuminate\Support\Collection;

#[Property('format', SpreadsheetExportFormat::class, default: SpreadsheetExportFormat::XLSX)]
#[Property('sheets', 'array')]
#[Property('xlsxOptions', XlsxOptions::class)]
class SpreadsheetExport extends Type
{
    public function setFormat(SpreadsheetExportFormat $format): self
    {
        $this['attributes']['format'] = $format->value;
        return $this;
    }

    public function setSheets(Collection|array $sheets): self
    {
        $this['sheets'] = $sheets instanceof Collection ? $sheets->all() : $sheets;
        return $this;
    }

    public static function make(Spreadsheet $spreadsheet): self
    {
        return (new static([
            'format' => SpreadsheetExportFormat::XLSX->value,
            'sheets' => $spreadsheet->sheets->map(fn(Sheet $sheet) => $sheet->id)->all(),
            'xlsxOptions' => (new XlsxOptions)->propertySerialize(),
        ]));
    }
}
