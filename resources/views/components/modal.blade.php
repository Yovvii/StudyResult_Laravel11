<!-- Main modal -->
<div id="select-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Categories
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select your passion:</p>
                <ul class="space-y-4 mb-4">
                    @forelse ($categories as $category)
                        <li class="flex items-center">
                            <div x-data="{ open: false }" class="relative inline-block text-left me-5">
                                <!-- Burger Button -->
                                <button @click="open = !open" class="p-2 rounded hover:bg-gray-200 focus:outline-none">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-md z-10">

                                    <a href="{{ url('posts/'.$category->id.'/ubah') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>

                                    {{-- <form action="/posts/{{ $category->id }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ url('posts/'.$category->id.'/hapus') }}" class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100">Delete</a>
                                    </form> --}}
                                    <form action="{{ route('posts.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are You Sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </div>

                            <a href="/posts?category={{ $category->slug }}" 
                            class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer 
                                    dark:hover:text-gray-300 dark:border-gray-500 hover:text-gray-900 hover:bg-gray-100 
                                    dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                                
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">{{ $category->name }}</div>
                                </div>
                                
                                <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" 
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" 
                                        stroke-linejoin="round" stroke-width="2" 
                                        d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </li>

                    @empty
                        <li>Tidak ada data</li>
                    @endforelse
                </ul>

                <a href="/tambah"
                    class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add New Category
                </a>
                

                

            </div>
        </div>
    </div>
</div> 
