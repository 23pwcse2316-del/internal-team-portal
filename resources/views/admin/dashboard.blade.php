<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
            <div>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    ← Back to Dashboard
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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Users</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Workspaces</div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_workspaces'] }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Channels</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['total_channels'] }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Messages</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_messages'] }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Tasks</div>
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['total_tasks'] }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Files</div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['total_files'] }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users') }}" class="block text-blue-600 hover:text-blue-800">
                                👥 Manage Users
                            </a>
                            <a href="{{ route('admin.workspaces') }}" class="block text-green-600 hover:text-green-800">
                                🏢 Manage Workspaces
                            </a>
                            <a href="{{ route('admin.channels') }}" class="block text-yellow-600 hover:text-yellow-800">
                                # Manage Channels
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
                        <div class="space-y-2 text-sm">
                            <p>👤 Latest user: {{ $recent_users->first()?->username ?? 'None' }}</p>
                            <p>🏢 Latest workspace: {{ $recent_workspaces->first()?->workspace_name ?? 'None' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Recent Users</h3>
                    @if($recent_users->count() > 0)
                        <div class="space-y-2">
                            @foreach($recent_users as $user)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <span>{{ $user->username }} ({{ $user->email }})</span>
                                    <span class="text-sm text-gray-500">{{ $user->user_type }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No users yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>