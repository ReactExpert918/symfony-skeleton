<?php

namespace App\Helpers;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    public static function authUser($request)
    {
        $data = $request->all();

        $client = self::get(false);
        try {
            $response = $client->request('POST', '/api/v2/token', ['body' => json_encode($data)]);
            $data_response = json_decode($response->getBody()->getContents(), true);
            Cache::put('token_key', $data_response['token_key'], now()->addMinutes(1440));
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        // < request user data
        $client = self::get();
        try {
            $response = $client->request('GET', '/api/v2/me');
            $data_user = json_decode($response->getBody()->getContents(), true);
            Cache::put('user_data', (object)$data_user, now()->addMinutes(1440));
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }
        // > request user data
    }

    public function getAuthorInfo($author_id) {
        $client = self::get();
        try {
            $response = $client->request('GET', '/api/v2/authors/'.$author_id);
            $response_data = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $response_data;
    }


    public function getAuthors() {
        $client = self::get();
        try {
            $response = $client->request('GET', '/api/v2/authors', [
                'query' => [
                    'orderBy' => 'id',
                    'direction' => 'ASC',
                    'limit' => 12,
                    'page' => 1
                ]
            ]);
            $response_data = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $response_data;
    }

    public function authorStore($request) {
        $data = $request->all();
        $birthday = DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $data['birthday'] = $birthday->format('Y-m-d');

        $client = self::get();
        try {
            $response = $client->request(
                'POST',
                '/api/v2/authors',
                ['body' => json_encode($data)]
            );
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $response;
    }

    public function authorDestroy($author) {
        $client = self::get();
        try {
            $response = $client->delete('/api/v2/authors/'.$author);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $response;
    }

    public function bookStore($request) {
        $data = $request->all();

        $data['author']['id'] = (int)$data['author']['id'];
        $release_date = DateTime::createFromFormat('d/m/Y', $data['release_date']);
        $data['release_date'] = $release_date->format('Y-m-d');
        $data['number_of_pages'] = (int)$data['number_of_pages'];

        $client = self::get();
        try {
            $response = $client->request(
                'POST',
                '/api/v2/books',
                ['body' => json_encode($data)]
            );
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $data;
    }

    public function bookDestroy($request, $book) {
        $data = $request->all();

        $client = self::get();
        try {
            $response = $client->delete('/api/v2/books/'.$book);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
        }

        return $data;
    }

}
