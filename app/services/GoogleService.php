<?php

namespace App\Services;

use Google\Client; // Import Google Client
use Google\Service\Oauth2; // Import Google Oauth2 Service
use Google\Service\GenerativeLanguage; // Import Google Generative Language Service
use Illuminate\Support\Facades\Session;


class GoogleService
{
    public function authenticate()
    {
        $client = new Client();
        $client->setAuthConfig('path/to/your/credentials.json'); // Set path to Google API credentials file

        $oauth2 = new Oauth2($client);
        return $oauth2;
    }

    public function generateContent($prompt)
    {
        $client = new Client();
        $client->setAccessToken(Session::get('google_token'));

        $geminiService = new GenerativeLanguage($client);

        return $geminiService->models->generateContent('gemini-1.5-flash', [
            'prompt' => $prompt,
        ]);
    }
}
