<?php

namespace Apility\Workiva\Enums;

enum OperationStatus: string
{
    case Acknowledged = 'acknowledged';
    case Queued = 'queued';
    case Started = 'started';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Failed = 'failed';
}
