<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Workspace;
use App\Models\Message;
use App\Models\PublicChannel;
use App\Models\PrivateChannel;
use App\Models\PrivateChannelMembership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    // Show form to create a new channel
    public function create($workspace_id)
    {
        $workspace = Workspace::findOrFail($workspace_id);
        $user = Auth::user();
        
        $membership = $workspace->members()->where('workspace_memberships.user_id', $user->user_id)->first();
        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can create channels.');
        }

        $users = $workspace->members;

        return view('channels.create', compact('workspace', 'users'));
    }

    // Store a new channel
    public function store(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,workspace_id',
            'channel_name' => 'required|string|max:100',
            'channel_type' => 'required|in:Public,Private',
            'invited_users' => 'nullable|array',
            'invited_users.*' => 'exists:users,user_id',
        ]);

        $workspace = Workspace::findOrFail($request->workspace_id);
        $user = Auth::user();
        
        $membership = $workspace->members()->where('workspace_memberships.user_id', $user->user_id)->first();
        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can create channels.');
        }

        try {
            $channel = Channel::create([
                'workspace_id' => $request->workspace_id,
                'channel_name' => $request->channel_name,
                'channel_type' => $request->channel_type,
                'created_at' => now(),
            ]);

            if ($request->channel_type === 'Public') {
                PublicChannel::create([
                    'channel_id' => $channel->channel_id,
                    'is_default' => false,
                ]);
            } else {
                PrivateChannel::create([
                    'channel_id' => $channel->channel_id,
                    'invite_only' => true,
                ]);

                // Add creator as a member
                PrivateChannelMembership::create([
                    'channel_id' => $channel->channel_id,
                    'user_id' => $user->user_id,
                    'invited_by' => $user->user_id,
                    'joined_at' => now(),
                ]);

                // Add invited users
                if ($request->has('invited_users')) {
                    foreach ($request->invited_users as $invitedUserId) {
                        if ($invitedUserId != $user->user_id) {
                            PrivateChannelMembership::create([
                                'channel_id' => $channel->channel_id,
                                'user_id' => $invitedUserId,
                                'invited_by' => $user->user_id,
                                'joined_at' => now(),
                            ]);
                        }
                    }
                }
            }

            return redirect()->route('workspaces.show', $request->workspace_id)
                             ->with('success', 'Channel "' . $request->channel_name . '" created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Failed to create channel: ' . $e->getMessage())
                             ->withInput();
        }
    }

    // Show a specific channel with its messages
    public function show($workspace_id, $channel_id)
    {
        $workspace = Workspace::findOrFail($workspace_id);
        $user = Auth::user();
        
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $channel = Channel::where('channel_id', $channel_id)
            ->where('workspace_id', $workspace_id)
            ->firstOrFail();

        if ($channel->channel_type === 'Private') {
            $privateChannel = PrivateChannel::where('channel_id', $channel_id)->first();
            if ($privateChannel) {
                $isMember = $privateChannel->members()
                    ->where('private_channel_memberships.user_id', $user->user_id)
                    ->exists();
                
                if (!$isMember) {
                    abort(403, 'You do not have access to this private channel.');
                }
            }
        }

        $messages = Message::with(['author', 'attachments', 'replies', 'replies.author'])
            ->where('channel_id', $channel_id)
            ->whereNull('parent_message_id')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $isAdmin = $membership->pivot->role === 'Admin';
        $userRole = $membership->pivot->role;

        $members = $channel->getPrivateMembers();

        return view('channels.show', compact('workspace', 'channel', 'messages', 'isAdmin', 'userRole', 'members'));
    }

    // 🔥 FIXED: Show invite form for private channel
    public function inviteForm($workspace_id, $channel_id)
{
    $workspace = Workspace::findOrFail($workspace_id);
    $channel = Channel::where('channel_id', $channel_id)
        ->where('workspace_id', $workspace_id)
        ->firstOrFail();

    $user = Auth::user();

    $membership = $workspace->members()
        ->where('workspace_memberships.user_id', $user->user_id)
        ->first();

    if (!$membership || $membership->pivot->role !== 'Admin') {
        abort(403, 'Only workspace admins can invite users.');
    }

    // 🔥 Fix ambiguous user_id
    $existingMemberIds = $channel->privateChannel->members()
        ->pluck('private_channel_memberships.user_id')
        ->toArray();

    $availableUsers = $workspace->members()
        ->whereNotIn('users.user_id', $existingMemberIds)
        ->get();

    return view('channels.invite', compact('workspace', 'channel', 'availableUsers'));
}
    // 🔥 FIXED: Add members to private channel
    public function invite(Request $request, $workspace_id, $channel_id)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,user_id',
        ]);

        $workspace = Workspace::findOrFail($workspace_id);
        $channel = Channel::where('channel_id', $channel_id)
            ->where('workspace_id', $workspace_id)
            ->firstOrFail();

        $user = Auth::user();

        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();

        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can invite users.');
        }

        // Add invited users
        foreach ($request->user_ids as $userId) {
            PrivateChannelMembership::firstOrCreate([
                'channel_id' => $channel->channel_id,
                'user_id' => $userId,
            ], [
                'invited_by' => $user->user_id,
                'joined_at' => now(),
            ]);
        }

        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', 'Users invited successfully!');
    }

    // Remove member from private channel
    public function removeMember($workspace_id, $channel_id, $user_id)
    {
        $workspace = Workspace::findOrFail($workspace_id);
        $channel = Channel::where('channel_id', $channel_id)
            ->where('workspace_id', $workspace_id)
            ->firstOrFail();

        $user = Auth::user();

        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();

        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can remove members.');
        }

        PrivateChannelMembership::where('channel_id', $channel->channel_id)
            ->where('user_id', $user_id)
            ->delete();

        return redirect()->back()->with('success', 'Member removed successfully!');
    }
}