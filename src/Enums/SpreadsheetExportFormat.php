<?php

namespace Apility\Workiva\Enums;

enum SpreadsheetExportFormat: string
{
    case PDF = 'pdf';
    case XLSX = 'xlsx';
    case CSV = 'csv';
}
