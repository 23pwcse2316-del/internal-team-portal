<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invite Users to #{{ $channel->channel_name }}
            </h2>
            <div>
                <a href="{{ route('channels.show', [$workspace->workspace_id, $channel->channel_id]) }}" 
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
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>#{{ $channel->channel_name }}</strong> is a private channel.
                            <br>
                            Current members: <strong>{{ $channel->privateChannel->members->count() }}</strong>
                        </p>
                    </div>

                    @if($availableUsers->count() > 0)
                        <!-- 🔥 UPDATED: Form action uses new route name -->
                        <form method="POST" action="{{ route('channels.invite.submit', [$workspace->workspace_id, $channel->channel_id]) }}">
                            @csrf

                            <div class="mb-4">
                                <label for="user_ids" class="block text-sm font-medium text-gray-700">
                                    Select users to invite
                                </label>
                                <select name="user_ids[]" id="user_ids" multiple
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        style="height: 200px;"
                                        required>
                                    @foreach($availableUsers as $user)
                                        <option value="{{ $user->user_id }}">
                                            {{ $user->username }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-400 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple users.</p>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('channels.show', [$workspace->workspace_id, $channel->channel_id]) }}" 
                                   class="text-gray-600 hover:text-gray-900 mr-4">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Invite Selected Users
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">All workspace members are already in this private channel.</p>
                            <a href="{{ route('channels.show', [$workspace->workspace_id, $channel->channel_id]) }}" 
                               class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                                Back to Channel
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>