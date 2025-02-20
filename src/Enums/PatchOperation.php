<?php

namespace Apility\Workiva\Enums;

enum PatchOperation: string
{
    case Add = 'add';
    case Remove = 'remove';
    case Replace = 'replace';
    case Move = 'move';
    case Copy = 'copy';
    case Test = 'test';
}
