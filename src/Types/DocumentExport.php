<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Enums\DocumentFormat;

#[Property('docxOptions', DocumentToDocxOptions::class)]
#[Property('format', DocumentFormat::class)]
#[Property('pdfOptions', DocumentToPdfOptions::class)]
#[Property('sections', 'string', collection: true)]
#[Property('xhtmlOptions', DocumentToXhtmlOptions::class)]
class DocumentExport extends Type
{
    public static function make(Document $document): self
    {
        return new static([
            'format' => DocumentFormat::XHMTL->value,
            'sections' => $document->sections->pluck('id')->all(),
        ]);
    }
}
