<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function generatePdfFromUrl($url): string
    {
        $response = $this->client->request(
            'POST',
            'http://localhost:3000/forms/chromium/convert/url',

            [
                'headers' =>[
                    'Content-Type' => 'multipart/form-data'
                ],
                'body' => ['url'=>$url]
            ]
        );

        return $response->getContent();
    }
}