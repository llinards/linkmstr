<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Link</h2>
        <a href="{{ route('links.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">← Back to Links</a>
    </div>

    @if (session('message'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="updateLink">
        <div class="mb-6">
            <label for="originalUrl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL to shorten <span class="text-red-500">*</span></label>
            <input wire:model="originalUrl" type="url" id="originalUrl" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="https://example.com/very/long/url/to/shorten" required>
            @error('originalUrl') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title (optional)</label>
            <input wire:model="title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="My awesome link">
            @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description (optional)</label>
            <textarea wire:model="description" id="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="A brief description about this link"></textarea>
            @error('description') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="expiresAt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiration Date (optional)</label>
                <input wire:model="expiresAt" type="datetime-local" id="expiresAt" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white">
                @error('expiresAt') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="customCode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Short Code</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-zinc-600 dark:text-gray-400 dark:border-zinc-600">
                        {{ url('/') }}/
                    </span>
                    <input wire:model="customCode" type="text" id="customCode" class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                @error('customCode') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center mb-6">
            <input wire:model="isActive" id="isActive" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="isActive" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Link is active</label>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                Update Link
            </button>

            <a href="{{ route('links.index') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-zinc-700 dark:text-gray-300 dark:border-zinc-500 dark:hover:text-white dark:hover:bg-zinc-600 dark:focus:ring-zinc-600">
                Cancel
            </a>
        </div>
    </form>
</div>
