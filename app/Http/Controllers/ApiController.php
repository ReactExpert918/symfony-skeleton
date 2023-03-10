<?php

namespace App\Http\Controllers;

use App\Helpers\ApiClientHelper;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function getToken(Request $request)
    {
        ApiClientHelper::authUser($request);

        return view('dashboard');
    }

    public function getAuthors() {
        $client = new ApiClientHelper;
        $response_data = $client->getAuthors();

        return view('author.index')->withAuthors($response_data['items']);
    }

    public function authorCreate() {

        return view('author.create');
    }

    public function authorStore(StoreAuthorRequest $request) {
        $client = new ApiClientHelper;
        $response = $client->authorStore($request);

        return redirect()->route('authors')->withSuccess(__('Author was successfully created.'));
    }

    public function authorDestroy($author) {
        $client = new ApiClientHelper;
        $authorInfo = $client->getAuthorInfo($author);

        if (!empty($authorInfo['books'])) {
            return redirect()->route('authors')->withFail(__('You can\'t delete author that has books.'));
        }
        else {
            $response = $client->authorDestroy($author);

            return redirect()->route('authors')->withSuccess(__('Author was successfully deleted.'));
        }
    }

    public function authorShow($author) {
        $client = new ApiClientHelper;
        $authorInfo = $client->getAuthorInfo($author);

        return view('author.show')->withAuthor($authorInfo);
    }

    public function bookCreate() {
        $client = new ApiClientHelper;
        $response_data = $client->getAuthors();

        return view('book.create')->withAuthors($response_data['items']);
    }

    public function bookStore(StoreBookRequest $request) {
        $client = new ApiClientHelper;
        $data = $client->bookStore($request);

        return redirect()->route('authors.show', $data['author']['id'] )->withSuccess(__('Book was successfully created.'));
    }

    public function bookDestroy(Request $request, $book) {
        $client = new ApiClientHelper;
        $data = $client->bookDestroy($request, $book);

        return redirect()->route('authors.show', $data['author'])->withSuccess(__('Book was successfully deleted.'));
    }


}
