# Workiva API Client

## Install

```bash
composer require apility/workiva-laravel
```

## Publish the config

```bash
php artisan vendor:publish --provider="Apility\Workiva\WorkivaServiceProvider" --tag="config"
```

### Usage

#### Listing documents

```php
<?php

use Apility\Workiva\Types\Document;

$documents = Document::list();
```

#### Listing sections in a document

```php
$sections = $documents->first()->sections;
```

#### Exporting a document

Document export happens asynchronous. This example uses polling to wait for the document to get exported.

In a production system, it's highly recommended that you instead dispatches a job to handle this, as it could take several minutes for the export to be completed.

```php
use Apility\Workiva\Facades\Workiva;
use Apility\Workiva\Enums\OperationStatus;
use Exception;

$request = [
    'format' => 'xhtml',
    'sections' => [
        $sections->first()->id, // Example, just pass in the ID's of the sections you want to export
    ],
    'xhtmlOptions' => [
        'editableXhtml' => true,
    ],
];

$response = Workiva::post(sprintf('documents/%s/export', $document->id), $request);
$location = $response->header('Location');
$retryAfter = $response->header('Retry-After') ?? 0;

sleep($retryAfter);

$export = null;

while (true) {
    $response = Workiva::get($location);

    if ($response->json()['status'] === OperationStatus::Completed->value) {
        $documentUrl = $response->json()['resourceUrl'];
        try {
            $exportResponse = Workiva::dontThrow()
                ->http()
                ->withoutRedirecting($documentUrl)
                ->get($documentUrl);

            header('Content-Type: ' . $exportResponse->header('Content-Type'));
            header('Content-Disposition: attachment; filename="' . $this->name . '.html"');
            $export = $exportResponse->body();
            break;
        } catch (Exception $e) {
            throw new Exception('Failed to export document:' . $e->getMessage());
        }
    }

    sleep($response->header('Retry-After') ?? 0);
}

Storage::put($document->name . '.html', $export);
```

---

Copyright Apility AS &copy; 2025