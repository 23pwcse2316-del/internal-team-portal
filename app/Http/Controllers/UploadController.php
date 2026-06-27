<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\FileAttachment;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    // Upload a file attachment for a message
    public function upload(Request $request, $workspace_id, $channel_id, $message_id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        // Check if user is a member
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        // Find the message
        $message = Message::where('message_id', $message_id)
            ->whereHas('channel', function($query) use ($channel_id, $workspace_id) {
                $query->where('channel_id', $channel_id)
                      ->where('workspace_id', $workspace_id);
            })
            ->firstOrFail();

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        // Generate unique storage key
        $storageKey = uniqid() . '_' . time() . '_' . $originalName;

        // Store file in storage/app/public/uploads
        $path = $file->storeAs('uploads', $storageKey, 'public');

        if (!$path) {
            return redirect()->back()->with('error', 'Failed to upload file.');
        }

        // Create attachment record
        $attachment = FileAttachment::create([
            'message_id' => $message_id,
            'file_name' => $originalName,
            'file_url' => Storage::url($path),
            'storage_key' => $storageKey,
            'mime_type' => $mimeType,
            'file_size_bytes' => $fileSize,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', 'File "' . $originalName . '" uploaded successfully!');
    }

    // Download a file
    public function download($workspace_id, $channel_id, $message_id, $attachment_id)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        // Check if user is a member
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership) {
            abort(403, 'You are not a member of this workspace.');
        }

        // Find the attachment
        $attachment = FileAttachment::where('attachment_id', $attachment_id)
            ->where('message_id', $message_id)
            ->firstOrFail();

        $filePath = 'uploads/' . $attachment->storage_key;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $attachment->file_name);
    }

    // Delete a file attachment
    public function destroy($workspace_id, $channel_id, $message_id, $attachment_id)
    {
        $user = Auth::user();
        $workspace = Workspace::findOrFail($workspace_id);
        
        // Check if user is an admin
        $membership = $workspace->members()
            ->where('workspace_memberships.user_id', $user->user_id)
            ->first();
        
        if (!$membership || $membership->pivot->role !== 'Admin') {
            abort(403, 'Only workspace admins can delete file attachments.');
        }

        // Find the attachment
        $attachment = FileAttachment::where('attachment_id', $attachment_id)
            ->where('message_id', $message_id)
            ->firstOrFail();

        // Delete file from storage
        $filePath = 'uploads/' . $attachment->storage_key;
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Delete database record
        $attachment->delete();

        return redirect()->route('channels.show', [$workspace_id, $channel_id])
                         ->with('success', 'File deleted successfully!');
    }
}