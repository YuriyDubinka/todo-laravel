<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Task Name</label>
                        <input type="text" name="title"
                            value="{{ old('title', $task->title) }}"
                            required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="">No Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:underline self-center">Cancel</a>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Task
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>