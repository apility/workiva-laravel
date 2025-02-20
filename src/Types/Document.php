<?php

namespace Apility\Workiva\Types;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Concerns\HasSubResources;
use Apility\Workiva\Concerns\IsRetrievable;
use Apility\Workiva\Enums\OperationStatus;
use Apility\Workiva\Facades\Workiva;
use Exception;
use Illuminate\Support\Facades\Http;

#[Property('created', Action::class)]
#[Property('id', 'string')]
#[Property('modified', Action::class)]
#[Property('name', 'string')]
#[Property('sections', Section::class, collection: true)]
#[Property('template', 'bool')]
/**
 * @property Action|null $created
 * @property string|null $id
 * @property Action|null $modified
 * @property string|null $name
 * @property Collection<int, Section> $sections
 * @property bool|null $template
 */
class Document extends Type
{
    use IsRetrievable;

    protected array $cache = [];

    public function getSectionsAttribute(): array
    {
        if (!isset($this->cache['sections'])) {
            $this->cache['sections'] = Workiva::get(sprintf('documents/%s/sections', $this->id))
                ->json()['data'] ?? [];
        }

        return $this->cache['sections'];
    }

    public function export(): string
    {
        $request = [
            'format' => 'xhtml',
            'sections' => $this->sections->pluck('id'),
            'xhtmlOptions' => [
                'editableXhtml' => true,
            ],
        ];

        $response = Workiva::post(sprintf('documents/%s/export', $this->id), $request);
        $location = $response->header('Location');
        $retryAfter = $response->header('Retry-After') ?? 0;

        sleep($retryAfter);

        while (true) {
            $response = Workiva::get($location);

            if ($response->json()['status'] === OperationStatus::Completed->value) {
                $documentUrl = $response->json()['resourceUrl'];
                try {
                    $exportResponse = Workiva::dontThrow()->http()->withoutRedirecting($documentUrl)
                        ->get($documentUrl);

                    header('Content-Type: ' . $exportResponse->header('Content-Type'));
                    header('Content-Disposition: attachment; filename="' . $this->name . '.html"');
                    die($exportResponse->body());
                    /* dd($exportResponse->effectiveUri(), $exportResponse->rque); */
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
                break;
            }

            sleep($response->header('Retry-After') ?? 0);
        }

        return dd(Workiva::get($location)->json());
    }
}
