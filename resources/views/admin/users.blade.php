<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Users
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

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->user_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($user->user_type == 'Admin') bg-red-100 text-red-800
                                            @elseif($user->user_type == 'Guest') bg-gray-100 text-gray-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ $user->user_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        📝 {{ $user->messages_count ?? 0 }} messages
                                        <br>
                                        🏢 {{ $user->workspaces_count ?? 0 }} workspaces
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-y-1">
                                        @if($user->user_type != 'Admin')
                                            <form method="POST" action="{{ route('admin.users.make-admin', $user->user_id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm block">
                                                    Make Admin
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.remove-admin', $user->user_id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm block">
                                                    Remove Admin
                                                </button>
                                            </form>
                                        @endif
                                        @if($user->user_id != Auth::id())
                                            <form method="POST" action="{{ route('admin.users.delete', $user->user_id) }}" class="inline"
                                                  onsubmit="return confirm('Delete this user?');">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm block">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>