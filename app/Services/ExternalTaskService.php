<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalTaskService
{
    private const BASE_URL =
        'https://jsonplaceholder.typicode.com';

    public function getExternalTasks(): array
    {
        return $this->sendRequest('GET', '/todos');
    }

    public function getExternalTaskById(int $id): array
    {
        return $this->sendRequest('GET', '/todos/' . $id);
    }

    public function sendTaskData(array $data): array
    {
        return $this->sendRequest('POST', '/todos', [
            'title' => $data['title'],
            'completed' => $data['completed'],
            'userId' => $data['userId'],
        ]);
    }

    private function sendRequest(
        string $method,
        string $path,
        array $data = []
    ): array {
        $url = self::BASE_URL . $path;

        try {
            $client = Http::timeout(5)->acceptJson();

            if ($method === 'POST') {
                $response = $client->post($url, $data);
            } else {
                $response = $client->get($url);
            }

            return $this->handleResponse(
                $response,
                $method,
                $path
            );
        } catch (ConnectionException $e) {
            Log::error('External API connection error', [
                'method' => $method,
                'path' => $path,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status' => 503,
                'error' => 'External API connection failed.',
            ];
        }
    }

    private function handleResponse(
        Response $response,
        string $method,
        string $path
    ): array {
        $status = $response->status();

        if ($response->successful()) {
            $result = $response->json();

            if (!is_array($result)) {
                Log::error('External API invalid JSON', [
                    'method' => $method,
                    'path' => $path,
                    'status' => $status,
                ]);

                return [
                    'success' => false,
                    'status' => 502,
                    'error' => 'Invalid external API response.',
                ];
            }

            Log::info('External API request successful', [
                'method' => $method,
                'path' => $path,
                'status' => $status,
            ]);

            return [
                'success' => true,
                'status' => $status,
                'data' => $result,
            ];
        }

        if ($response->failed()) {
            Log::error('External API request failed', [
                'method' => $method,
                'path' => $path,
                'status' => $status,
            ]);

            return [
                'success' => false,
                'status' => $status === 404 ? 404 : 502,
                'error' => 'External API returned HTTP ' . $status,
            ];
        }

        Log::error('Unexpected external API response', [
            'method' => $method,
            'path' => $path,
            'status' => $status,
        ]);

        return [
            'success' => false,
            'status' => 502,
            'error' => 'Unexpected external API response.',
        ];
    }
}
