<?php

namespace App\Services;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Resources\Parts\ImagePart;
use GeminiAPI\Enums\MimeType;

class GeminiApiService
{
    protected $client;

    public function __construct()
    {
        // Initialize the Gemini client with your API key
        $this->client = new Client('GEMINI_API_KEY');
    }

    public function generateContent($prompt)
    {
        // Generate content based on the provided prompt
        $response = $this->client->geminiPro()->generateContent(
            new TextPart($prompt)
        );

        return $response->text();
    }

    public function startChat($message)
    {
        $chat = $this->client->geminiPro()->startChat();
        $response = $chat->sendMessage(new TextPart($message));

        return $response->text();
    }

    public function generateContentFromImage($imagePath)
    {
        $response = $this->client->geminiProVision()->generateContent(
            new TextPart('Explain what is in the image'),
            new ImagePart(
                MimeType::IMAGE_JPEG,
                base64_encode(file_get_contents($imagePath))
            )
        );

        return $response->text();
    }
}
