<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if($errors->any())
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2" style="text-align: center">
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <form method="POST" action="{{ route('books.store') }}" name="create-item" enctype="multipart/form-data">
                    @csrf

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="first_name">
                                First Name
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select data-te-select-init name="author[id]">
                                @foreach($authors as $author)
                                    <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="title">
                                Title
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                   id="title"
                                   name="title"
                                   type="text"
                                   placeholder="{{ __('Title ') }}"
                                   maxlength="150">
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="release_date">
                                release date
                            </label>
                        </div>
                        <div class="relative mb-3 xl:w-96"
                             data-te-datepicker-init
                             data-te-input-wrapper-init>
                            <input type="text"
                                   id="release_date"
                                   name="release_date"
                                   class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                   placeholder="Select a date" />
                            <label for="floatingInput"
                                   class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                Select a date</label>
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="description">Description</label>
                        </div>
                        <div class="md:w-2/3">
                            <textarea class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                   id="description"
                                   name="description"
                                   placeholder="{{ __('Description ') }}"
                                   rows="5"></textarea>
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="isbn">
                                isbn
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                   id="isbn"
                                   name="isbn"
                                   type="text"
                                   placeholder="{{ __('isbn ') }}"
                                   maxlength="150">
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="format">
                                format
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                   id="format"
                                   name="format"
                                   type="text"
                                   placeholder="{{ __('format ') }}"
                                   maxlength="150">
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold text-right mb-1 md:mb-0 pr-4" for="number_of_pages">
                                number of pages
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                   id="number_of_pages"
                                   name="number_of_pages"
                                   type="text"
                                   placeholder="{{ __('number of pages ') }}"
                                   maxlength="150">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/3">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>


