<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;

/**
 * @property bool|null $editableSimple
 * @property bool|null $editableXhtml
 * @property bool|null $includeExternalHyperlinks
 * @property bool|null $includeHeadersAndFooters
 */
#[Property('editableSimple', 'bool', default: false)]
#[Property('editableXhtml', 'bool', default: true)]
#[Property('includeExternalHyperlinks', 'bool', default: true)]
#[Property('includeHeadersAndFooters', 'bool', default: true)]
class DocumentToXhtmlOptions extends Type
{
    //
}
