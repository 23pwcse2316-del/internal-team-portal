<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Channels
            </h2>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    ← Back to Admin
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workspace</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Messages</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($channels as $channel)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $channel->channel_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">#{{ $channel->channel_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $channel->workspace->workspace_name ?? 'Deleted' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($channel->channel_type == 'Public') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $channel->channel_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $channel->messages_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form method="POST" action="{{ route('admin.channels.delete', $channel->channel_id) }}" class="inline"
                                              onsubmit="return confirm('Delete this channel and all its messages?');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $channels->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>