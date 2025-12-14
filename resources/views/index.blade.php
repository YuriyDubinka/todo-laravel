<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-4 mb-8">
                        @csrf
                        <div class="flex-1 flex gap-2">
                            <input type="text" name="title" placeholder="What needs to be done?" required
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">

                            <select name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">No Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-semibold shadow-sm transition">
                            Add
                        </button>
                    </form>
                    <div class="mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                        <span class="text-gray-600 font-medium">Filter by:</span>

                        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2 w-full">

                            <div class="relative flex-1 max-w-xs">
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search tasks..."
                                    class="border-gray-300 text-sm rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full pl-8">
                                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <select name="filter_category_id" onchange="this.form.submit()"
                                class="border-gray-300 text-sm rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('filter_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>

                            <button type="submit" class="bg-gray-800 text-white text-sm px-3 py-2 rounded-md hover:bg-gray-700">
                                Search
                            </button>

                            @if(request('filter_category_id') || request('search'))
                            <a href="{{ route('dashboard') }}" class="text-sm text-red-500 hover:text-red-700 underline ml-2">
                                Clear
                            </a>
                            @endif
                        </form>
                    </div>
                    @if ($tasks->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($tasks as $task)
                        <li class="flex justify-between items-center py-4">
                            <div class="flex items-center gap-3">
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-6 h-6 rounded border flex items-center justify-center transition-colors {{ $task->is_completed ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-gray-400' }}">
                                        @if($task->is_completed)
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        @endif
                                    </button>
                                </form>

                                <div class="flex flex-col">
                                    <span class="text-lg {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>

                                    @if($task->category)
                                    <span class="text-xs text-indigo-500 font-semibold bg-indigo-50 px-2 py-1 rounded w-fit">
                                        {{ $task->category->name }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700 font-bold px-2">
                                ✎
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-bold px-3 py-1 rounded hover:bg-red-50 transition">
                                    Delete
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        {{ $tasks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">You have no tasks yet. Add one above! 🚀</p>
            </div>
            @endif

        </div>
    </div>
    </div>
    </div>
</x-app-layout>