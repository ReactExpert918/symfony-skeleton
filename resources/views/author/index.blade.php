<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(Session::has('fail'))
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2" style="text-align: center">
                    {{Session::get('fail')}}
                </div>
            </div>
        @endif
        @if(Session::has('success'))
            <div role="success">
                <div class="bg-success-200 text-success-700 font-bold rounded-t px-4 py-2" style="text-align: center">
                    {{Session::get('success')}}
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-nav-link :href="route('authors.create')">
                {{ __('Create New Author') }}
            </x-nav-link>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Birthday</th>
                            <th>gender</th>
                            <th>place_of_birth</th>
                            <th>Action</th>
                        </tr>
                        @foreach($authors as $author)
                            <tr>
                                <td>{{ $author['id'] }}</td>
                                <td>{{ $author['first_name'] }}</td>
                                <td>{{ $author['last_name'] }}</td>
                                <td>{{ date('Y-m-d', strtotime($author['birthday'])) }}</td>
                                <td>{{ $author['gender'] }}</td>
                                <td>{{ $author['place_of_birth'] }}</td>
                                <td>
                                    <a href="/authors/{{ $author['id'] }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        View
                                    </a>
                                    <form method="POST" action="/authors/{{ $author['id'] }}" name="delete-item" style="display: inline !important;">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="ml-3">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>


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