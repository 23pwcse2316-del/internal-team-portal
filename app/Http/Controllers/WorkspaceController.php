<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WorkspaceMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    // Show all workspaces (dashboard)
    public function index()
    {
        $user = Auth::user();
        $workspaces = $user->workspaces;
        return view('dashboard', compact('workspaces'));
    }

    // Show form to create a new workspace
    public function create()
    {
        return view('workspaces.create');
    }

    // Store a new workspace
    public function store(Request $request)
    {
        $request->validate([
            'workspace_name' => 'required|string|max:100|unique:workspaces,workspace_name',
        ]);

        // Create the workspace
        $workspace = Workspace::create([
            'workspace_name' => $request->workspace_name,
            'creator_id' => Auth::id(),
            'created_at' => now(),
        ]);

        // Add the creator as an Admin member
        WorkspaceMembership::create([
            'user_id' => Auth::id(),
            'workspace_id' => $workspace->workspace_id,
            'role' => 'Admin',
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Workspace created successfully!');
    }

    // Show a single workspace with channels and members
    public function show($id)
    {
        // 🔥 Load workspace with channels and members
        $workspace = Workspace::with(['channels', 'members'])->findOrFail($id);
        $user = Auth::user();
        
        // 🔥 Check if user is a member - specify table to avoid ambiguity
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        // Check if user is an admin
        $isAdmin = false;
        $userRole = 'Member';
        
        foreach ($workspace->members as $member) {
            if ($member->user_id == $user->user_id) {
                $userRole = $member->pivot->role;
                if ($member->pivot->role === 'Admin') {
                    $isAdmin = true;
                }
                break;
            }
        }

        return view('workspaces.show', compact('workspace', 'membership', 'isAdmin', 'userRole'));
    }
}