<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Concerns\IsRetrievable;
use Apility\Workiva\Facades\Workiva;
use Illuminate\Support\Collection;

/**
 * @property Action|null $created
 * @property string|null $id
 * @property Action|null $modified
 * @property string|null $name
 * @property Collection<int, Sheet> $sheets
 * @property Collection<int, Dataset> $datasets
 * @property bool|null $template
 */
#[Property('created', Action::class)]
#[Property('id', 'string')]
#[Property('modified', Action::class)]
#[Property('name', 'string')]
#[Property('sheets', Sheet::class, collection: true)]
#[Property('datasets', Dataset::class, collection: true)]
#[Property('template', 'bool')]
class Spreadsheet extends Type
{
    use IsRetrievable;

    protected array $cache = [];

    public function getSheetsAttribute(): array
    {
        if (!isset($this->cache['sheets'])) {
            $this->cache['sheets'] = Workiva::get(sprintf('spreadsheets/%s/sheets', $this->id))
                ->json()['data'] ?? [];
        }

        return $this->cache['sheets'];
    }

    public function getDatasetsAttribute(): array
    {
        if (!isset($this->cache['datasets'])) {
            $this->cache['datasets'] = Workiva::get(sprintf('spreadsheets/%s/datasets', $this->id))
                ->json()['data'] ?? [];
        }

        return $this->cache['datasets'];
    }

    public function export(?SpreadsheetExport $export = null): string
    {
        $options = $export ?? SpreadsheetExport::make($this);
        $response = Workiva::post(sprintf('spreadsheets/%s/export', $this->id, $options->jsonSerialize()));

        return $response->header('Location');
    }
}
