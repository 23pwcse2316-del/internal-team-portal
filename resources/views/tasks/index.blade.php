<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Tasks
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

            <!-- Task Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Total Tasks</div>
                    <div class="text-2xl font-bold">{{ $assignedTasks->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Open</div>
                    <div class="text-2xl font-bold text-gray-600">
                        {{ $assignedTasks->where('status', 'Open')->count() }}
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-sm text-gray-500">Completed</div>
                    <div class="text-2xl font-bold text-green-600">
                        {{ $assignedTasks->where('status', 'Completed')->count() }}
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($assignedTasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($assignedTasks as $task)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <span class="text-xl">{{ $task->statusIcon }}</span>
                                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $task->statusBadge }}">
                                                    {{ $task->status }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-gray-800">{{ $task->description }}</p>
                                            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-500">
                                                <span>📋 From: <a href="{{ route('channels.show', [$task->channel->workspace->workspace_id, $task->channel->channel_id]) }}" 
                                                                  class="text-blue-500 hover:text-blue-700">
                                                    #{{ $task->channel->channel_name }}
                                                </a></span>
                                                <span>👤 Assignee: <strong>{{ $task->assignee->username ?? 'Unassigned' }}</strong></span>
                                                <span>👤 Creator: {{ $task->creator->username ?? 'Unknown' }}</span>
                                                @if($task->due_date)
                                                    <span>📅 Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <!-- Status Update Form -->
                                            <form method="POST" action="{{ route('tasks.update', $task->task_id) }}" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()" 
                                                        class="text-sm border rounded px-2 py-1">
                                                    <option value="Open" {{ $task->status == 'Open' ? 'selected' : '' }}>Open</option>
                                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </form>
                                            <!-- Delete Button - Uses $isAdmin -->
                                            @if($task->creator_id == Auth::id() || $isAdmin)
                                                <form method="POST" action="{{ route('tasks.destroy', $task->task_id) }}" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No tasks assigned to you yet.</p>
                            <p class="text-sm text-gray-400 mt-2">Tasks will appear here when someone assigns them to you.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>