<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- THIS IS THE HEADER WITH THE BUTTON -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Your Workspaces</h3>
                        <!-- CREATE WORKSPACE BUTTON - LOOK RIGHT HERE -->
                        <a href="{{ route('workspaces.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Create Workspace
                        </a>
                    </div>
                    
                    <!-- Workspace Cards -->
                    @if($workspaces->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($workspaces as $workspace)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <h4 class="font-bold text-lg text-blue-600">
                                        {{ $workspace->workspace_name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Created by: {{ $workspace->creator->username ?? 'Unknown' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Your role: 
                                        <span class="font-semibold 
                                            @if($workspace->pivot->role == 'Admin') text-red-600
                                            @elseif($workspace->pivot->role == 'Guest') text-gray-500
                                            @else text-green-600 @endif">
                                            {{ $workspace->pivot->role ?? 'Member' }}
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Channels: {{ $workspace->channels->count() }}
                                    </p>
                                    <a href="{{ route('workspaces.show', $workspace->workspace_id) }}" 
                                       class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                                        View Workspace
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">You are not a member of any workspace yet.</p>
                            <a href="{{ route('workspaces.create') }}" 
                               class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                                Create Your First Workspace
                            </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>