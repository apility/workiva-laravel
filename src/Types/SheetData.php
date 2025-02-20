<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Illuminate\Support\Collection;

/**
 * @property array $cells
 * @property Collection<int, ColumnMetadata> $columnMetadata
 * @property Collection<int, Range> $merges
 * @property Range $range
 * @property Collection<int, RowMetadata> $rowMetadata
 */
#[Property('cells', 'array')]
#[Property('columnMetadata', ColumnMetadata::class, collection: true)]
#[Property('merges', Range::class, collection: true)]
#[Property('range', Range::class)]
#[Property('rowMetadata', RowMetadata::class, collection: true)]
class SheetData extends Type
{
    //
}
