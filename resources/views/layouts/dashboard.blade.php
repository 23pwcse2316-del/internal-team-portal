<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    👋 Welcome back, <span class="gradient-text">{{ Auth::user()->username }}</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">Here's what's happening in your workspaces</p>
            </div>
            <a href="{{ route('workspaces.create') }}" 
               class="btn-primary-custom px-6 py-2 rounded-xl font-semibold flex items-center gap-2 text-sm shadow-lg shadow-indigo-500/25">
                <i class="bi bi-plus-circle"></i> Create Workspace
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-center gap-3">
                    <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($workspaces->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($workspaces as $workspace)
                        <div class="workspace-card hover-lift">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="icon">
                                        <i class="bi bi-building text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg">{{ $workspace->workspace_name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            <i class="bi bi-person-circle mr-1"></i>
                                            {{ $workspace->creator->username ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($workspace->pivot->role == 'Admin') bg-red-100 text-red-600
                                    @elseif($workspace->pivot->role == 'Guest') bg-gray-100 text-gray-600
                                    @else bg-green-100 text-green-600 @endif">
                                    {{ $workspace->pivot->role ?? 'Member' }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="bi bi-hash mr-1"></i> {{ $workspace->channels->count() }} channels</span>
                                <span><i class="bi bi-people mr-1"></i> {{ $workspace->members->count() }} members</span>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('workspaces.show', $workspace->workspace_id) }}" 
                                   class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-medium px-4 py-2 rounded-lg text-center text-sm transition flex items-center justify-center gap-2">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">🏗️</div>
                    <h3 class="text-xl font-semibold text-gray-700">No workspaces yet</h3>
                    <p class="text-gray-500 mt-2">Create your first workspace to get started with team collaboration</p>
                    <a href="{{ route('workspaces.create') }}" 
                       class="btn-primary-custom px-6 py-3 rounded-xl font-semibold inline-flex items-center gap-2 mt-4 shadow-lg shadow-indigo-500/25">
                        <i class="bi bi-plus-circle"></i> Create Workspace
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>