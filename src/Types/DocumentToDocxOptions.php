<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;

/**
 * @property bool|null $includeLeaderDots
 * @property bool|null $showTableCellShading
 */
#[Property('includeLeaderDots', 'bool')]
#[Property('showTableCellShading', 'bool')]
class DocumentToDocxOptions extends Type
{
    //
}
