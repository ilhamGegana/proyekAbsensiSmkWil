<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonnteService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client(['base_uri' => 'https://api.fonnte.com/']);
    }

    public function send(string $target, string $message): array
    {
        $res = $this->http->post('send', [
            'headers' => [
                'Authorization' => config('services.fonnte.token'),
            ],
            'multipart' => [
                ['name' => 'target',  'contents' => $target],
                ['name' => 'message', 'contents' => $message],
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}
