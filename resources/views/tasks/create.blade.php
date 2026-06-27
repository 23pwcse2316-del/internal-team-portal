<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Task from Message
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Original Message -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-500">Original Message:</p>
                        <p class="mt-1 text-gray-800">{{ $message->content }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            Posted by {{ $message->author->username }} 
                            on {{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y H:i') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        
                        <input type="hidden" name="message_id" value="{{ $message->message_id }}">

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Task Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Describe the task to be done..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Assignee -->
                        <div class="mb-4">
                            <label for="assignee_id" class="block text-sm font-medium text-gray-700">Assign To</label>
                            <select name="assignee_id" id="assignee_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Select a user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}" {{ old('assignee_id') == $user->user_id ? 'selected' : '' }}>
                                        {{ $user->username }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assignee_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Due Date -->
                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                            <input type="date" name="due_date" id="due_date" 
                                   value="{{ old('due_date') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-400 mt-1">Format: YYYY-MM-DD (e.g., {{ date('Y-m-d', strtotime('+7 days')) }})</p>
                            @error('due_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('channels.show', [$workspace->workspace_id, $message->channel_id]) }}" 
                               class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Task
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>