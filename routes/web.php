<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
require __DIR__.'/auth.php';

// ============================================
// 🔥 PROTECTED ROUTES (All require login)
// ============================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Workspace routes
    Route::get('/workspaces/create', [WorkspaceController::class, 'create'])->name('workspaces.create');
    Route::post('/workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');
    Route::get('/workspaces/{id}', [WorkspaceController::class, 'show'])->name('workspaces.show');

    // Channel routes
    Route::get('/workspaces/{workspace_id}/channels/create', [ChannelController::class, 'create'])->name('channels.create');
    Route::post('/channels', [ChannelController::class, 'store'])->name('channels.store');
    Route::get('/workspaces/{workspace_id}/channels/{channel_id}', [ChannelController::class, 'show'])->name('channels.show');

    // 🔥 FIXED: Private channel routes with UNIQUE names
    Route::get('/workspaces/{workspace_id}/channels/{channel_id}/invite', [ChannelController::class, 'inviteForm'])->name('channels.invite');
    Route::post('/workspaces/{workspace_id}/channels/{channel_id}/invite', [ChannelController::class, 'invite'])->name('channels.invite.submit'); // ✅ Unique name
    Route::delete('/workspaces/{workspace_id}/channels/{channel_id}/members/{user_id}', [ChannelController::class, 'removeMember'])->name('channels.remove-member');

    // Message routes
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/pin', [MessageController::class, 'pin'])->name('messages.pin');
    Route::get('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/edit', [MessageController::class, 'edit'])->name('messages.edit');
    Route::put('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // File upload routes
    Route::post('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/upload', [UploadController::class, 'upload'])->name('upload.upload');
    Route::get('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/attachments/{attachment_id}/download', [UploadController::class, 'download'])->name('upload.download');
    Route::delete('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/attachments/{attachment_id}', [UploadController::class, 'destroy'])->name('upload.destroy');

    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/workspaces/{workspace_id}/channels/{channel_id}/messages/{message_id}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task_id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task_id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Profile routes
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user_id}', [UserProfileController::class, 'show'])->name('profile.show.user');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-picture', [UserProfileController::class, 'uploadPicture'])->name('profile.upload-picture');
    Route::post('/profile/remove-picture', [UserProfileController::class, 'removePicture'])->name('profile.remove-picture');
    Route::get('/profile/change-password', [UserProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update-password');

});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user_id}/make-admin', [AdminController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{user_id}/remove-admin', [AdminController::class, 'removeAdmin'])->name('users.remove-admin');
    Route::delete('/users/{user_id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/workspaces', [AdminController::class, 'workspaces'])->name('workspaces');
    Route::delete('/workspaces/{workspace_id}', [AdminController::class, 'deleteWorkspace'])->name('workspaces.delete');
    Route::get('/channels', [AdminController::class, 'channels'])->name('channels');
    Route::delete('/channels/{channel_id}', [AdminController::class, 'deleteChannel'])->name('channels.delete');
});

// Test route
Route::get('/test-profile', function() {
    return '✅ TEST: Routing is working!';
});