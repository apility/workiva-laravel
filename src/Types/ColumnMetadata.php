<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;

/**
 * @property bool|null $hidden
 * @property int|null $size
 */
#[Property('hidden', 'bool')]
#[Property('size', 'integer')]
class ColumnMetadata extends Type
{
    //
}
