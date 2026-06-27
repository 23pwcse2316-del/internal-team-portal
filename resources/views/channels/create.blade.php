<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Channel in {{ $workspace->workspace_name }}
            </h2>
            <a href="{{ route('workspaces.show', $workspace->workspace_id) }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Workspace
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('channels.store') }}">
                        @csrf
                        <input type="hidden" name="workspace_id" value="{{ $workspace->workspace_id }}">

                        <!-- Channel Name -->
                        <div class="mb-4">
                            <label for="channel_name" class="block text-sm font-medium text-gray-700">Channel Name</label>
                            <input type="text" name="channel_name" id="channel_name" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g., general, project-updates, random"
                                   required>
                            @error('channel_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Channel Type -->
                        <div class="mb-4">
                            <label for="channel_type" class="block text-sm font-medium text-gray-700">Channel Type</label>
                            <select name="channel_type" id="channel_type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Select type...</option>
                                <option value="Public">Public - Anyone in the workspace can join</option>
                                <option value="Private">Private - Only invited members can access</option>
                            </select>
                            @error('channel_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 🔥 NEW: Invite Users (Only for Private Channels) -->
                        <div id="invite-section" class="mb-4" style="display: none;">
                            <label for="invited_users" class="block text-sm font-medium text-gray-700">
                                Invite Members
                            </label>
                            <select name="invited_users[]" id="invited_users" multiple
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    style="height: 150px;">
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}">
                                        {{ $user->username }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Hold Ctrl to select multiple users. You will be automatically added.</p>
                            @error('invited_users')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('workspaces.show', $workspace->workspace_id) }}" 
                               class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Channel
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- 🔥 JavaScript to show/hide invite section -->
<script>
    document.getElementById('channel_type').addEventListener('change', function() {
        const inviteSection = document.getElementById('invite-section');
        if (this.value === 'Private') {
            inviteSection.style.display = 'block';
        } else {
            inviteSection.style.display = 'none';
        }
    });
</script>