<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

/**
 * Class HtmlHelper.
 */
class ApiClientHelper
{
    const API_SERVER = 'https://symfony-skeleton.q-tests.com';

    public static function get($auth = true)
    {
        $headers = [];

        if ($auth) {
            $token = Cache::get('token_key');
            $headers = [
                'Authorization' => $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];
        }

        $client = new Client([
            'headers' => $headers,
            'base_uri' => static::API_SERVER,
            'timeout'  => 2.0,
        ]);

        return $client;
    }

}
