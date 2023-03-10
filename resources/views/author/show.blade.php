<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(Session::has('success'))
            <div role="success">
                <div class="bg-success-200 text-success-700 font-bold rounded-t px-4 py-2" style="text-align: center">
                    {{Session::get('success')}}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-nav-link :href="route('books.create')">
                {{ __('Create New Book') }}
            </x-nav-link>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2>Author</h2>
                    <table>
                        <tr>
                            <td>id</td>
                            <td><b>{{ $author['id'] }}</b></td>
                        </tr>
                        <tr>
                            <td>first_name</td>
                            <td><b>{{ $author['first_name'] }}</b></td>
                        </tr>
                        <tr>
                            <td>last_name</td>
                            <td><b>{{ $author['last_name'] }}</b></td>
                        </tr>
                        <tr>
                            <td>birthday</td>
                            <td><b>{{ date('Y-m-d', strtotime($author['birthday'])) }}</b></td>
                        </tr>
                        <tr>
                            <td>biography</td>
                            <td><b>{{ $author['biography'] }}</b></td>
                        </tr>
                        <tr>
                            <td>gender</td>
                            <td><b>{{ $author['gender'] }}</b></td>
                        </tr>
                        <tr>
                            <td>place_of_birth</td>
                            <td><b>{{ $author['place_of_birth'] }}</b></td>
                        </tr>
                    </table>

                    <hr width="100%" style="margin: 20px 0">

                    @if (!empty($author['books']))
                        <h2>Books</h2>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>title</th>
                                <th>release_date</th>
                                <th>description</th>
                                <th>isbn</th>
                                <th>format</th>
                                <th>number_of_pages</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($author['books'] as $book)
                                <tr>
                                    <td>{{ $book['id'] }}</td>
                                    <td>{{ $book['title'] }}</td>
                                    <td>{{ date('Y-m-d', strtotime($book['release_date'])) }}</td>
                                    <td>{{ $book['description'] }}</td>
                                    <td>{{ $book['isbn'] }}</td>
                                    <td>{{ $book['format'] }}</td>
                                    <td>{{ $book['number_of_pages'] }}</td>
                                    <td>
                                        <form method="POST" action="/books/{{ $book['id'] }}" name="delete-item" style="display: inline !important;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="author" value="{{ $author['id'] }}">
                                            <x-danger-button class="ml-3">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        There are no books for this author.
                    @endif

                    <hr width="100%" style="margin: 20px 0">

                    <x-nav-link :href="route('books.create')">
                        {{ __('Create New Book') }}
                    </x-nav-link>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>

    td,th {
        border: 1px solid;
        padding: 5px 15px;
    }
</style>