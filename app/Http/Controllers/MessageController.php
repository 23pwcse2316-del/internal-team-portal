<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Channel;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Store a new message or reply
    public function store(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|exists:channels,channel_id',
            'workspace_id' => 'required|exists:workspaces,workspace_id',
            'content' => 'required|string|max:5000',
            'parent_message_id' => 'nullable|exists:messages,message_id',
        ]);

        $user = Auth::user();
        $workspace = Workspace::findOrFail($request->workspace_id);
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $channel = Channel::where('channel_id', $request->channel_id)
            ->where('workspace_id', $request->workspace_id)
            ->firstOrFail();

        if ($channel->channel_type === 'Private') {
            $privateChannel = $channel->privateChannel;
            if ($privateChannel) {
                $isMember = $privateChannel->members()
                    ->where('private_channel_memberships.user_id', $user->user_id)
                    ->exists();
                
                if (!$isMember) {
                    abort(403, 'You do not have access to this private channel.');
                }
            }
        }

        $message = Message::create([
            'channel_id' => $request->channel_id,
            'author_id' => $user->user_id,
            'parent_message_id' => $request->parent_message_id ?? null,
            'content' => $request->content,
            'is_pinned' => false,
            'pinned_at' => null,
            'created_at' => now(),
            'edited_at' => null,
        ]);

        return redirect()->route('channels.show', [
            $request->workspace_id, 
            $request->channel_id
        ])->with('success', $request->parent_message_id ? 'Reply sent successfully!' : 'Message sent successfully!');
    }

    // 🔥 NEW: Show edit form
    public function edit($workspace_id, $channel_id, $message_id)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $message = Message::where('message_id', $message_id)
            ->whereHas('channel', function($query) use ($channel_id) {
                $query->where('channel_id', $channel_id);
            })
            ->firstOrFail();

        // Check if user can edit
        if ($message->author_id !== $user->user_id) {
            abort(403, 'You can only edit your own messages.');
        }

        return view('messages.edit', compact('workspace', 'message'));
    }

    // 🔥 NEW: Update a message
    public function update(Request $request, $workspace_id, $channel_id, $message_id)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $message = Message::where('message_id', $message_id)
            ->whereHas('channel', function($query) use ($channel_id) {
                $query->where('channel_id', $channel_id);
            })
            ->firstOrFail();

        // Check if user can edit
        if ($message->author_id !== $user->user_id) {
            abort(403, 'You can only edit your own messages.');
        }

        // Update the message
        $message->content = $request->content;
        $message->edited_at = now();
        $message->save();

        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', 'Message updated successfully!');
    }

    // 🔥 NEW: Delete a message
    public function destroy($workspace_id, $channel_id, $message_id)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $isAdmin = $membership->pivot->role === 'Admin';

        $message = Message::where('message_id', $message_id)
            ->whereHas('channel', function($query) use ($channel_id) {
                $query->where('channel_id', $channel_id);
            })
            ->firstOrFail();

        // Check if user can delete (own message OR admin)
        if ($message->author_id !== $user->user_id && !$isAdmin) {
            abort(403, 'You can only delete your own messages.');
        }

        // Check if message has replies
        if ($message->replies()->count() > 0) {
            return redirect()->route('channels.show', [$workspace_id, $channel_id])
                             ->with('error', 'Cannot delete a message that has replies. Delete the replies first.');
        }

        $message->delete();

        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', 'Message deleted successfully!');
    }

    // Pin a message
    public function pin($workspace_id, $channel_id, $message_id)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can pin messages.');
        }

        $message = Message::where('message_id', $message_id)
            ->whereHas('channel', function($query) use ($workspace_id) {
                $query->where('workspace_id', $workspace_id);
            })
            ->firstOrFail();

        $message->togglePin();

        $status = $message->is_pinned ? 'pinned' : 'unpinned';
        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', "Message {$status} successfully!");
    }
}