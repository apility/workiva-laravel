<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Enums\XlsxPrecision;

/**
 * @property bool|null $exportAsFormulas
 * @property XlsxPrecision|null $exportPrecision
 */
#[Property('exportAsFormulas', 'bool', nullable: false)]
#[Property('exportPrecision', XlsxPrecision::class, default: XlsxPrecision::Full, nullable: false)]
class XlsxOptions extends Type
{
    //
}
