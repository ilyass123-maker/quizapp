<?php

namespace App\Services;

use GuzzleHttp\Client;

class LlamaApiService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('LLAMA_API_KEY');
        $this->baseUrl = env('LLAMA_API_BASE_URL');
    }

    public function generateQuestion($subject)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/generate", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'prompt' => "Generate a quiz question for the subject: {$subject}",
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['result'] ?? null;
        } catch (\Exception $e) {
            \Log::error('Llama API Error: ' . $e->getMessage());
            return null;
        }
    }
}
