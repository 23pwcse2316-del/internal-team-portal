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
                    
                    <!-- THIS IS THE HEADER WITH THE BUTTON - IT'S RIGHT HERE -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="font-size: 1.125rem; font-weight: bold;">Your Workspaces</h3>
                        <!-- CREATE WORKSPACE BUTTON - VISIBLE NOW -->
                        <a href="/workspaces/create" 
                           style="background-color: #3b82f6; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                            + Create Workspace
                        </a>
                    </div>
                    
                    <!-- Workspace Cards -->
                    @if($workspaces->count() > 0)
                        <div style="display: grid; grid-template-columns: 1fr; gap: 16px; @media (min-width: 768px) { grid-template-columns: 1fr 1fr; } @media (min-width: 1024px) { grid-template-columns: 1fr 1fr 1fr; }">
                            @foreach($workspaces as $workspace)
                                <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; transition: box-shadow 0.3s;">
                                    <h4 style="font-weight: bold; font-size: 1.125rem; color: #2563eb;">
                                        {{ $workspace->workspace_name }}
                                    </h4>
                                    <p style="font-size: 0.875rem; color: #4b5563; margin-top: 4px;">
                                        Created by: {{ $workspace->creator->username ?? 'Unknown' }}
                                    </p>
                                    <p style="font-size: 0.875rem; color: #6b7280;">
                                        Your role: 
                                        <span style="font-weight: 600; color: #dc2626;">
                                            {{ $workspace->pivot->role ?? 'Member' }}
                                        </span>
                                    </p>
                                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">
                                        Channels: {{ $workspace->channels->count() }}
                                    </p>
                                    <a href="/workspaces/{{ $workspace->workspace_id }}" 
                                       style="display: inline-block; margin-top: 12px; background-color: #3b82f6; color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.875rem; text-decoration: none;">
                                        View Workspace
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 32px 0;">
                            <p style="color: #6b7280;">You are not a member of any workspace yet.</p>
                            <a href="/workspaces/create" 
                               style="display: inline-block; margin-top: 12px; background-color: #3b82f6; color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.875rem; text-decoration: none;">
                                Create Your First Workspace
                            </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>