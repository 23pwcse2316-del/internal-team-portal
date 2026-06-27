<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Workspaces
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channels</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($workspaces as $workspace)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $workspace->workspace_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $workspace->workspace_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $workspace->creator->username ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $workspace->channels_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $workspace->members_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form method="POST" action="{{ route('admin.workspaces.delete', $workspace->workspace_id) }}" class="inline"
                                              onsubmit="return confirm('Delete this workspace and all its data?');">
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
                        {{ $workspaces->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>