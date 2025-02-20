<?php

namespace Apility\Workiva\Contracts;

use Closure;

interface PropertySerialization
{
    public function getPropertySerializer(): Closure;
}
