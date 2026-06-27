<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Workspace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="/workspaces">
                        @csrf

                        <div class="mb-4">
                            <label for="workspace_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151;">Workspace Name</label>
                            <input type="text" name="workspace_name" id="workspace_name" 
                                   style="margin-top: 4px; display: block; width: 100%; border-radius: 4px; border: 1px solid #d1d5db; padding: 8px 12px;"
                                   required>
                            @error('workspace_name')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 16px;">
                            <a href="/dashboard" style="color: #4b5563; margin-right: 16px; text-decoration: none;">Cancel</a>
                            <button type="submit" style="background-color: #3b82f6; color: white; font-weight: bold; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                                Create Workspace
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>