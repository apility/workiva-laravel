<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Concerns\HasParent;

/**
 * @property string|null $range
 * @property string|null $sheet
 * @property array|null $values
 */
#[Property('range', 'string')]
#[Property('sheet', 'string')]
#[Property('values', 'array')]
class Dataset extends Type
{
    use HasParent;
}
