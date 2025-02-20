<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Carbon\CarbonImmutable;

#[Property('dateTime', CarbonImmutable::class)]
#[Property('user', User::class)]
class Action extends Type
{
    //
}
