<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Concerns\HasParent;
use Apility\Workiva\Facades\Workiva;

use Illuminate\Support\Collection;

/**
 * @property Collection<int, Sheet> $children
 * @property DataSet $dataset
 * @property string|null $id
 * @property int|null $index
 * @property string|null $name
 * @property Sheet|null $parent
 * @property SheetData|null $sheetData
 */
#[Property('children', Sheet::class, collection: true)]
#[Property('dataset', Dataset::class)]
#[Property('id', 'string')]
#[Property('index', 'integer')]
#[Property('name', 'string')]
#[Property('parent', Sheet::class, serialize: false)]
#[Property('sheetData', SheetData::class)]
class Sheet extends Type
{
    use HasParent;

    public function getSheetDataAttribute(): array
    {
        return Workiva::get(sprintf('spreadsheets/%s/sheets/%s/sheetdata', $this->getParent()?->id ?? '0', $this->id))->json()['data'] ?? [];
    }
}
