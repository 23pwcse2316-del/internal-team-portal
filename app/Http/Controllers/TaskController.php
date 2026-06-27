<?php

namespace App\Http\Controllers;

use App\Models\TaskItem;
use App\Models\Message;
use App\Models\Workspace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    // Show all tasks for the current user
    public function index()
{
    $user = Auth::user();
    $assignedTasks = TaskItem::with(['message', 'assignee', 'creator', 'channel'])
        ->where('assignee_id', $user->user_id)
        ->orWhere('creator_id', $user->user_id)
        ->orderBy('created_at', 'desc')
        ->get();

    $userWorkspaceIds = $user->workspaces->pluck('workspace_id');
    // 🔥 Fix ambiguous workspace_id – use workspaces.workspace_id
    $users = User::whereHas('workspaces', function($query) use ($userWorkspaceIds) {
        $query->whereIn('workspaces.workspace_id', $userWorkspaceIds);
    })->get();

    $isAdmin = false;
    foreach ($user->workspaces as $workspace) {
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        if ($membership && $membership->pivot->role === 'Admin') {
            $isAdmin = true;
            break;
        }
    }

    return view('tasks.index', compact('assignedTasks', 'users', 'isAdmin'));
}

    // Show form to create a task from a message
    public function create($workspace_id, $channel_id, $message_id)
    {
        $workspace = Workspace::findOrFail($workspace_id);
        $message = Message::where('message_id', $message_id)
            ->where('channel_id', $channel_id)
            ->firstOrFail();
        
        $user = Auth::user();
        
        // Check if user is a member of the workspace
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        // Get workspace members for assignment dropdown
        $users = $workspace->members;

        return view('tasks.create', compact('workspace', 'message', 'users'));
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,message_id',
            'assignee_id' => 'required|exists:users,user_id',
            'description' => 'required|string|max:1000',
            'due_date' => 'nullable|date|after:today',
            'status' => ['required', Rule::in(['Open', 'In Progress', 'Completed'])],
        ]);

        $user = Auth::user();
        $message = Message::findOrFail($request->message_id);
        $workspace = $message->channel->workspace;

        // Check if user is a member of the workspace
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        // Create the task
        $task = TaskItem::create([
            'channel_id' => $message->channel_id,
            'message_id' => $request->message_id,
            'assignee_id' => $request->assignee_id,
            'creator_id' => $user->user_id,
            'description' => $request->description,
            'status' => $request->status ?? 'Open',
            'due_date' => $request->due_date,
            'created_at' => now(),
        ]);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task created successfully!');
    }

    // Update task status
    public function update(Request $request, $task_id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Open', 'In Progress', 'Completed'])],
        ]);

        $task = TaskItem::findOrFail($task_id);
        $user = Auth::user();

        // Check if user is the assignee OR creator OR workspace admin
        $workspace = $task->channel->workspace;
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();

        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $isAdmin = $membership->pivot->role === 'Admin';
        $isAssignee = $task->assignee_id === $user->user_id;
        $isCreator = $task->creator_id === $user->user_id;

        if (!$isAdmin && !$isAssignee && !$isCreator) {
            abort(403, 'You do not have permission to update this task.');
        }

        $task->status = $request->status;
        $task->save();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task status updated successfully!');
    }

    // Delete a task
    public function destroy($task_id)
    {
        $task = TaskItem::findOrFail($task_id);
        $user = Auth::user();

        $workspace = $task->channel->workspace;
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();

        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        $isAdmin = $membership->pivot->role === 'Admin';
        $isCreator = $task->creator_id === $user->user_id;

        if (!$isAdmin && !$isCreator) {
            abort(403, 'Only the task creator or workspace admin can delete tasks.');
        }

        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully!');
    }
}