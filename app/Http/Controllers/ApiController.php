<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\StoreBookRequest;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{

    public function getToken(Request $request)
    {
        $data = $request->all();

        $client = new Client();
        try {
            $response = $client->request('POST', 'https://symfony-skeleton.q-tests.com/api/v2/token', ['body' => json_encode($data)]);
            $data_response = json_decode($response->getBody()->getContents(), true);
            Cache::put('token_key', $data_response['token_key'], now()->addMinutes(1440));
        } catch (RequestException $e) {
            echo $e->getMessage();
        }


        // < request user data
        $client = $this->getClient();
        try {
            $response = $client->request('GET', '/api/v2/me');
            $data_user = json_decode($response->getBody()->getContents(), true);
            Cache::put('user_data', (object)$data_user, now()->addMinutes(1440));
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
        // > request user data

        return view('dashboard');
    }

    public function getAuthors() {
        $client = $this->getClient();

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
            echo $e->getMessage();
        }

        return view('author.index')->withAuthors($response_data['items']);
    }

    public function authorCreate() {

        return view('author.create');
    }

    public function authorStore(StoreAuthorRequest $request) {
        $data = $request->all();
        $birthday = DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $data['birthday'] = $birthday->format('Y-m-d');

        $client = $this->getClient();

        try {
            $response = $client->request(
                'POST',
                'https://symfony-skeleton.q-tests.com/api/v2/authors',
                ['body' => json_encode($data)]
            );
        } catch (RequestException $e) {
            echo $e->getMessage();
        }

        return redirect()->route('authors')->withSuccess(__('Author was successfully created.'));
    }

    public function authorDestroy($author) {
        $authorInfo = $this->getAuthorInfo($author);

        if (!empty($authorInfo['books'])) {
            return redirect()->route('authors')->withFail(__('You can\'t delete author that has books.'));
        }
        else {
            $client = $this->getClient();
            try {
                $response = $client->delete('/api/v2/authors/'.$author);
            } catch (RequestException $e) {
                echo $e->getMessage();
            }

            return redirect()->route('authors')->withSuccess(__('Author was successfully deleted.'));
        }
    }

    public function authorShow($author) {
        $authorInfo = $this->getAuthorInfo($author);

        return view('author.show')->withAuthor($authorInfo);
    }

    public function bookCreate() {
        $client = $this->getClient();
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
            echo $e->getMessage();
        }

        return view('book.create')->withAuthors($response_data['items']);
    }

    public function bookStore(StoreBookRequest $request) {
        $data = $request->all();

        $data['author']['id'] = (int)$data['author']['id'];
        $release_date = DateTime::createFromFormat('d/m/Y', $data['release_date']);
        $data['release_date'] = $release_date->format('Y-m-d');
        $data['number_of_pages'] = (int)$data['number_of_pages'];

        $client = $this->getClient();

        try {
            $response = $client->request(
                'POST',
                'https://symfony-skeleton.q-tests.com/api/v2/books',
                ['body' => json_encode($data)]
            );
        } catch (RequestException $e) {
            echo $e->getMessage();
        }

        return redirect()->route('authors.show', $data['author']['id'] )->withSuccess(__('Book was successfully created.'));
    }

    public function bookDestroy(Request $request, $book) {
        $data = $request->all();

        $client = $this->getClient();
        try {
            $response = $client->delete('/api/v2/books/'.$book);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }

        return redirect()->route('authors.show', $data['author'])->withSuccess(__('Book was successfully deleted.'));
    }

    public function getAuthorInfo($author_id) {
        $client = $this->getClient();

        try {
            $response = $client->request('GET', '/api/v2/authors/'.$author_id);
            $response_data = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }

        return $response_data;
    }

    private function getClient() {
        $token = Cache::get('token_key');

        $client = new Client([
            'headers' => [
                'Authorization' => $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'base_uri' => 'https://symfony-skeleton.q-tests.com/',
            'timeout'  => 2.0,
        ]);

        return $client;
    }
}
