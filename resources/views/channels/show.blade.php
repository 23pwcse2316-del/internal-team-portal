<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    # {{ $channel->channel_name }}
                </h2>
                <p class="text-sm text-gray-500">
                    in {{ $workspace->workspace_name }}
                </p>
            </div>
            <div>
                <a href="{{ route('workspaces.show', $workspace->workspace_id) }}" 
                   class="text-gray-600 hover:text-gray-900">
                    ← Back to Workspace
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

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Channel Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="inline-block px-2 py-1 rounded text-xs 
                                @if($channel->channel_type == 'Public') 
                                    bg-green-100 text-green-800
                                @else 
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                @if($channel->channel_type == 'Private')
                                    🔒 
                                @endif
                                {{ $channel->channel_type }}
                            </span>
                            <span class="text-sm text-gray-500 ml-2">
                                Created: {{ \Carbon\Carbon::parse($channel->created_at)->format('M d, Y') }}
                            </span>
                            <span class="text-sm text-gray-500 ml-2">
                                👥 {{ $members->count() }} members
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">
                                {{ $messages->count() }} messages
                            </span>
                            <!-- Invite Button - Only for Admins of Private Channels -->
                            @if($isAdmin && $channel->channel_type == 'Private')
                                <a href="{{ route('channels.invite', [$workspace->workspace_id, $channel->channel_id]) }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white text-sm px-3 py-1 rounded font-medium">
                                    + Invite Members
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($messages->count() > 0)
                        <div class="space-y-4">
                            @foreach($messages as $message)
                                <!-- Root Message -->
                                <div class="{{ $message->is_pinned ? 'bg-yellow-50 p-4 rounded-lg border-2 border-yellow-400' : 'border-b pb-4' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="font-bold">{{ $message->author->username ?? 'Unknown' }}</span>
                                            <span class="text-xs text-gray-500 ml-2">
                                                {{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y H:i') }}
                                            </span>
                                            @if($message->isEdited())
                                                <span class="ml-2 text-xs text-gray-400">(edited)</span>
                                            @endif
                                            @if($message->is_pinned)
                                                <span class="ml-2 bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded">📌 Pinned</span>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            @if($isAdmin)
                                                <form method="POST" action="{{ route('messages.pin', [$workspace->workspace_id, $channel->channel_id, $message->message_id]) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700 text-sm">
                                                        @if($message->is_pinned)
                                                            📌 Unpin
                                                        @else
                                                            📌 Pin
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                            @if($message->author_id == Auth::id())
                                                <a href="{{ route('messages.edit', [$workspace->workspace_id, $channel->channel_id, $message->message_id]) }}" 
                                                   class="text-blue-500 hover:text-blue-700 text-sm">
                                                    Edit
                                                </a>
                                            @endif
                                            @if($message->author_id == Auth::id() || $isAdmin)
                                                <form method="POST" action="{{ route('messages.destroy', [$workspace->workspace_id, $channel->channel_id, $message->message_id]) }}" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('tasks.create', [$workspace->workspace_id, $channel->channel_id, $message->message_id]) }}" 
                                               class="text-purple-500 hover:text-purple-700 text-sm">
                                                📋 Task
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-gray-800">{{ $message->content }}</p>
                                    </div>

                                    @if($message->attachments->count() > 0)
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @foreach($message->attachments as $attachment)
                                                <div class="bg-gray-100 rounded-lg p-2 flex items-center gap-2 border border-gray-200">
                                                    <span class="text-xl">{{ $attachment->fileIcon }}</span>
                                                    <div>
                                                        <a href="{{ route('upload.download', [$workspace->workspace_id, $channel->channel_id, $message->message_id, $attachment->attachment_id]) }}" 
                                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            {{ $attachment->file_name }}
                                                        </a>
                                                        <p class="text-xs text-gray-500">{{ $attachment->fileSize }}</p>
                                                    </div>
                                                    @if($isAdmin)
                                                        <form method="POST" action="{{ route('upload.destroy', [$workspace->workspace_id, $channel->channel_id, $message->message_id, $attachment->attachment_id]) }}" 
                                                              class="inline"
                                                              onsubmit="return confirm('Delete this file?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs ml-2">×</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-2">
                                        <a href="javascript:void(0)" 
                                           onclick="toggleReplyForm({{ $message->message_id }})" 
                                           class="text-blue-500 hover:text-blue-700 text-sm">
                                            Reply
                                        </a>
                                        <span class="text-gray-300 mx-1">|</span>
                                        <span class="text-gray-500 text-sm">
                                            {{ $message->replies->count() }} replies
                                        </span>
                                    </div>

                                    <div class="mt-2">
                                        <form method="POST" action="{{ route('upload.upload', [$workspace->workspace_id, $channel->channel_id, $message->message_id]) }}" 
                                              enctype="multipart/form-data"
                                              class="flex items-center gap-2">
                                            @csrf
                                            <input type="file" 
                                                   name="file" 
                                                   class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                   required>
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm px-3 py-1 rounded">
                                                Upload
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Reply Form -->
                                    <div id="reply-form-{{ $message->message_id }}" style="display: none;" class="mt-3 pt-3 border-t">
                                        <form method="POST" action="{{ route('messages.store') }}">
                                            @csrf
                                            <input type="hidden" name="workspace_id" value="{{ $workspace->workspace_id }}">
                                            <input type="hidden" name="channel_id" value="{{ $channel->channel_id }}">
                                            <input type="hidden" name="parent_message_id" value="{{ $message->message_id }}">
                                            
                                            <div class="flex gap-2">
                                                <input type="text" 
                                                       name="content"
                                                       placeholder="Reply to {{ $message->author->username }}..." 
                                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                       required>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                                    Reply
                                                </button>
                                                <button type="button" 
                                                        onclick="toggleReplyForm({{ $message->message_id }})" 
                                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Replies -->
                                    @if($message->replies->count() > 0)
                                        <div class="mt-3 ml-6 border-l-2 border-gray-200 pl-4 space-y-3">
                                            @foreach($message->replies as $reply)
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <span class="font-bold text-sm">{{ $reply->author->username ?? 'Unknown' }}</span>
                                                            <span class="text-xs text-gray-500 ml-2">
                                                                {{ \Carbon\Carbon::parse($reply->created_at)->format('M d, Y H:i') }}
                                                            </span>
                                                            @if($reply->isEdited())
                                                                <span class="ml-2 text-xs text-gray-400">(edited)</span>
                                                            @endif
                                                        </div>
                                                        <div class="flex gap-2">
                                                            @if($reply->author_id == Auth::id())
                                                                <a href="{{ route('messages.edit', [$workspace->workspace_id, $channel->channel_id, $reply->message_id]) }}" 
                                                                   class="text-blue-500 hover:text-blue-700 text-xs">
                                                                    Edit
                                                                </a>
                                                            @endif
                                                            @if($reply->author_id == Auth::id() || $isAdmin)
                                                                <form method="POST" action="{{ route('messages.destroy', [$workspace->workspace_id, $channel->channel_id, $reply->message_id]) }}" 
                                                                      class="inline"
                                                                      onsubmit="return confirm('Are you sure you want to delete this reply?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('tasks.create', [$workspace->workspace_id, $channel->channel_id, $reply->message_id]) }}" 
                                                               class="text-purple-500 hover:text-purple-700 text-xs">
                                                                📋 Task
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <p class="text-gray-700 text-sm">{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No messages in this channel yet.</p>
                            <p class="text-sm text-gray-400 mt-2">Be the first to send a message!</p>
                        </div>
                    @endif

                    <!-- New Message Input -->
                    <div class="mt-6 pt-4 border-t">
                        <form method="POST" action="{{ route('messages.store') }}">
                            @csrf
                            
                            <input type="hidden" name="workspace_id" value="{{ $workspace->workspace_id }}">
                            <input type="hidden" name="channel_id" value="{{ $channel->channel_id }}">
                            <input type="hidden" name="parent_message_id" value="">

                            <div class="flex gap-2">
                                <input type="text" 
                                       name="content"
                                       placeholder="Type a message..." 
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required
                                       autofocus>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                    Send
                                </button>
                            </div>
                        </form>
                        <p class="text-xs text-gray-400 mt-2">Press Enter to send or click Send button</p>
                    </div>

                    <!-- 🔥 PRIVATE CHANNEL MEMBERS LIST -->
                    @if($channel->channel_type == 'Private')
                        <div class="mt-6 pt-4 border-t">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-semibold text-sm">👥 Members</h4>
                                @if($isAdmin)
                                    <a href="{{ route('channels.invite', [$workspace->workspace_id, $channel->channel_id]) }}" 
                                       class="text-green-500 hover:text-green-700 text-sm">
                                        + Add Members
                                    </a>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($members as $member)
                                    <div class="bg-gray-100 rounded-full px-3 py-1 text-sm flex items-center gap-2">
                                        <span>{{ $member->username }}</span>
                                        @if($isAdmin && $member->user_id != Auth::id())
                                            <form method="POST" action="{{ route('channels.remove-member', [$workspace->workspace_id, $channel->channel_id, $member->user_id]) }}" 
                                                  class="inline"
                                                  onsubmit="return confirm('Remove this member from the private channel?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">×</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Total: {{ $members->count() }} members</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JavaScript -->
<script>
function toggleReplyForm(messageId) {
    const form = document.getElementById('reply-form-' + messageId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
        const input = form.querySelector('input[name="content"]');
        if (input) input.focus();
    } else {
        form.style.display = 'none';
    }
}
</script>