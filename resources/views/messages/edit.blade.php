<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Message
            </h2>
            <div>
                <a href="{{ route('channels.show', [$workspace->workspace_id, $message->channel_id]) }}" 
                   class="text-gray-600 hover:text-gray-900">
                    ← Back to Channel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">
                            Editing message by <strong>{{ $message->author->username }}</strong>
                            <br>
                            Original: {{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y H:i') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('messages.update', [$workspace->workspace_id, $message->channel_id, $message->message_id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="content" id="content" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      required>{{ old('content', $message->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('channels.show', [$workspace->workspace_id, $message->channel_id]) }}" 
                               class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Message
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>