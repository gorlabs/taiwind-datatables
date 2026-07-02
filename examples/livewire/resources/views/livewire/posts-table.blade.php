<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('Posts (Livewire Native Demo)') }}</h1>
        <button
            wire:click="createPost"
            class="px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
        >
            + {{ __('Add New Post') }}
        </button>
    </div>

    <div class="mb-4">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('Search by title...') }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
        />
    </div>

    <div class="border rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('id')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <span class="flex items-center gap-1">
                            ID
                            @if ($sortField === 'id')
                                <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </span>
                    </th>
                    <th wire:click="sortBy('title')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <span class="flex items-center gap-1">
                            Title
                            @if ($sortField === 'title')
                                <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </span>
                    </th>
                    <th wire:click="sortBy('content')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <span class="flex items-center gap-1">
                            Content
                            @if ($sortField === 'content')
                                <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </span>
                    </th>
                    <th wire:click="sortBy('published_at')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <span class="flex items-center gap-1">
                            Published At
                            @if ($sortField === 'published_at')
                                <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </span>
                    </th>
                    <th wire:click="sortBy('is_published')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <span class="flex items-center gap-1">
                            Status
                            @if ($sortField === 'is_published')
                                <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </span>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($posts as $post)
                    <tr wire:key="post-{{ $post->id }}" class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $post->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ Str::limit($post->title, 30) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ Str::limit($post->content, 30) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $post->published_at?->format('n/j/Y, g:i A') ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex gap-2">
                                <button
                                    wire:click="editPost({{ $post->id }})"
                                    class="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700"
                                >
                                    {{ __('Edit') }}
                                </button>
                                <button
                                    wire:click="deletePost({{ $post->id }})"
                                    wire:confirm="{{ __('Are you sure?') }}"
                                    class="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700"
                                >
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            {{ __('No posts found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">
                        {{ $form->post ? __('Edit Post') : __('Create New Post') }}
                    </h2>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="form.title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                        <input
                            type="text"
                            wire:model="form.title"
                            id="form.title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        />
                        @error('form.title') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="form.content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                        <textarea
                            wire:model="form.content"
                            id="form.content"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        ></textarea>
                        @error('form.content') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:model="form.is_published"
                            id="form.is_published"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm"
                        />
                        <label for="form.is_published" class="text-sm text-gray-900">{{ __('Published?') }}</label>
                    </div>

                    <div>
                        <label for="form.published_at" class="block text-sm font-medium text-gray-700">{{ __('Published Date (Optional)') }}</label>
                        <input
                            type="datetime-local"
                            wire:model="form.published_at"
                            id="form.published_at"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        />
                        @error('form.published_at') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        wire:click="$set('showModal', false)"
                        class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        wire:click="save"
                        class="px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4 text-sm text-gray-500">
        <p>This page uses native Livewire 3 components (PostsTable) instead of the Blade bridge.</p>
        <p>
            See <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Posts (Blade Bridge)</a> for the original version.
        </p>
    </div>
</div>
