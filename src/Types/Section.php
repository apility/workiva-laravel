<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Illuminate\Support\Collection;

/**
 * @property Collection<int, Section> $children
 * @property string|null $id
 * @property int|null $index
 * @property string|null $name
 * @property bool $nonPrinting
 * @property Section|null $parent
 */
#[Property('children', Section::class, collection: true)]
#[Property('id', 'string')]
#[Property('index', 'integer')]
#[Property('name', 'string')]
#[Property('nonPrinting', 'bool')]
#[Property('parent', Section::class, nullable: true)]
class Section extends Type
{
    //
}
