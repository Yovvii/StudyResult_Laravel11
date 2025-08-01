<x-layout>
    <x-slot:title>Add Category</x-slot:title>

    <section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <h1 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Edit {{ $category->name }} Category</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/posts/'.$category->id.'/atasdate') }}" class="space-y-8" method="POST">
            @csrf
            @method('PATCH')
            <div class="flex justify-between items-center">
                <aside class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                <input type="text" id="name" name="name" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" 
                value="{{ $category->name }}">
                </aside>
                
                <aside class="w-full ms-3">
                    <label for="color" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Color</label>
                    {{-- <input type="text" id="color" name="color" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"> --}}
                
                    <select id="color" name="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="gray" {{ $category->color === 'gray' ? 'selected' : '' }}>Gray</option>
                        <option value="red" {{ $category->color === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="yellow" {{ $category->color === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="green" {{ $category->color === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="blue" {{ $category->color === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="purple" {{ $category->color === 'purple' ? 'selected' : '' }}>Purple</option>
                        {{-- <option value="pink">Pink</option> --}}
                    </select>
                </aside>
            </div>
            <button type="submit" 
            class="mt-3 py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save Article</button>
        </form>
    </div>
    </section>
</x-layout>