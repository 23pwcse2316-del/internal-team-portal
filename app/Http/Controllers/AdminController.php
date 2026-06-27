<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use App\Models\Channel;
use App\Models\Message;
use App\Models\TaskItem;
use App\Models\FileAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_workspaces' => Workspace::count(),
            'total_channels' => Channel::count(),
            'total_messages' => Message::count(),
            'total_tasks' => TaskItem::count(),
            'total_files' => FileAttachment::count(),
        ];

        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_workspaces = Workspace::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_workspaces'));
    }

    // User Management
    public function users()
    {
        $users = User::withCount(['messages', 'workspaces'])->paginate(15);
        return view('admin.users', compact('users'));
    }

    // Make user admin
    public function makeAdmin($user_id)
    {
        $user = User::findOrFail($user_id);
        
        // Prevent demoting yourself
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $user->user_type = 'Admin';
        $user->save();

        // Add to admin_users table if not exists
        if (!$user->admin) {
            \DB::table('admin_users')->insert([
                'user_id' => $user->user_id,
                'can_invite' => true,
                'admin_since' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'User promoted to Admin successfully!');
    }

    // Remove admin role
    public function removeAdmin($user_id)
    {
        $user = User::findOrFail($user_id);
        
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot remove your own admin role.');
        }

        $user->user_type = 'Member';
        $user->save();

        // Remove from admin_users
        \DB::table('admin_users')->where('user_id', $user->user_id)->delete();

        return redirect()->back()->with('success', 'Admin role removed successfully!');
    }

    // Delete a user
    public function deleteUser($user_id)
    {
        $user = User::findOrFail($user_id);
        
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    // Workspace Management
    public function workspaces()
    {
        $workspaces = Workspace::withCount(['channels', 'members'])->paginate(15);
        return view('admin.workspaces', compact('workspaces'));
    }

    // Delete a workspace
    public function deleteWorkspace($workspace_id)
    {
        $workspace = Workspace::findOrFail($workspace_id);
        $workspace->delete();

        return redirect()->back()->with('success', 'Workspace deleted successfully!');
    }

    // Channel Management
    public function channels()
    {
        $channels = Channel::with(['workspace', 'messages'])->paginate(15);
        return view('admin.channels', compact('channels'));
    }

    // Delete a channel
    public function deleteChannel($channel_id)
    {
        $channel = Channel::findOrFail($channel_id);
        $channel->delete();

        return redirect()->back()->with('success', 'Channel deleted successfully!');
    }
}