<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl shadow-lg">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $workspace->workspace_name }}</h2>
                    <p class="text-gray-500 text-sm flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-600 font-semibold">
                            {{ $userRole ?? 'Member' }}
                        </span>
                        <span>•</span>
                        <span>{{ $workspace->members->count() }} members</span>
                        <span>•</span>
                        <span>{{ $workspace->channels->count() }} channels</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 text-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                @if($isAdmin)
                    <a href="{{ route('channels.create', $workspace->workspace_id) }}" 
                       class="btn-primary-custom px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-lg shadow-indigo-500/25">
                        <i class="bi bi-plus-circle"></i> Create Channel
                    </a>
                @endif
            </div>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Channels Column -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-4">
                                <i class="bi bi-hash text-indigo-500"></i>
                                Channels
                                <span class="text-sm text-gray-400 font-normal ml-2">({{ $workspace->channels->count() }})</span>
                            </h3>
                            
                            @if($workspace->channels->count() > 0)
                                <div class="space-y-3">
                                    @foreach($workspace->channels as $channel)
                                        <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition flex justify-between items-center hover:border-indigo-200">
                                            <div>
                                                <h4 class="font-semibold flex items-center gap-2">
                                                    <span class="text-indigo-500">#</span>
                                                    {{ $channel->channel_name }}
                                                </h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <span class="channel-badge {{ $channel->channel_type == 'Public' ? 'public' : 'private' }}">
                                                        {{ $channel->channel_type }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">
                                                        <i class="bi bi-clock mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($channel->created_at)->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('channels.show', [$workspace->workspace_id, $channel->channel_id]) }}" 
                                               class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-1">
                                                View <i class="bi bi-chevron-right text-xs"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="text-4xl mb-3">📢</div>
                                    <p class="text-gray-500">No channels yet</p>
                                    @if($isAdmin)
                                        <a href="{{ route('channels.create', $workspace->workspace_id) }}" 
                                           class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center gap-1 mt-2">
                                            <i class="bi bi-plus-circle"></i> Create your first channel
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Members Column -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-4">
                                <i class="bi bi-people text-indigo-500"></i>
                                Members
                                <span class="text-sm text-gray-400 font-normal ml-2">({{ $workspace->members->count() }})</span>
                            </h3>
                            <div class="space-y-3">
                                @foreach($workspace->members as $member)
                                    <div class="flex items-center justify-between border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar avatar-sm text-xs">
                                                {{ substr($member->username, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-sm">{{ $member->username }}</p>
                                                <p class="text-xs text-gray-400">
                                                    @if($member->pivot->role == 'Admin')
                                                        <span class="text-red-500 font-semibold">Admin</span>
                                                    @elseif($member->pivot->role == 'Guest')
                                                        <span class="text-gray-400">Guest</span>
                                                    @else
                                                        <span class="text-green-500">Member</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        @if($isAdmin && $member->user_id != Auth::id())
                                            <form method="POST" action="#" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs transition">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>