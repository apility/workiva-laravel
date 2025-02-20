<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;

/**
 * @property bool|null $includeAlternateRowFill
 * @property bool|null $includeAttachmentLabels
 * @property bool|null $includeComments
 * @property bool|null $includeDraftWatermark
 * @property bool|null $includeHyperlinks
 * @property bool|null $includeLeaderDots
 * @property bool|null $includeTrackChanges
 * @property bool|null $tagForWebAccessibility
 * @property bool|null $useCmykColorspace
 */
#[Property('includeAlternateRowFill', 'bool')]
#[Property('includeAttachmentLabels', 'bool')]
#[Property('includeComments', 'bool')]
#[Property('includeDraftWatermark', 'bool')]
#[Property('includeHyperlinks', 'bool')]
#[Property('includeLeaderDots', 'bool')]
#[Property('includeTrackChanges', 'bool')]
#[Property('tagForWebAccessibility', 'bool')]
#[Property('useCmykColorspace', 'bool')]
class DocumentToPdfOptions extends Type
{
    //
}
