<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Enums\PatchOperation;

/**
 * @property string|null $from
 * @property PatchOperation|null $op
 * @property string|null $path
 * @property mixed $value
 */
#[Property('from', 'string')]
#[Property('op', PatchOperation::class)]
#[Property('path', 'string')]
#[Property('value', 'mixed')]
class JSONPatchOperation extends Type
{
    //
}
