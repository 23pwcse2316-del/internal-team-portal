<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ============================================
        // 🔥 TRUNCATE ALL TABLES FIRST (Avoid duplicates)
        // ============================================
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('users')->truncate();
        DB::table('workspaces')->truncate();
        DB::table('workspace_memberships')->truncate();
        DB::table('channels')->truncate();
        DB::table('messages')->truncate();
        DB::table('file_attachments')->truncate();
        DB::table('task_items')->truncate();
        DB::table('admin_users')->truncate();
        DB::table('guest_users')->truncate();
        DB::table('public_channels')->truncate();
        DB::table('private_channels')->truncate();
        DB::table('private_channel_memberships')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================
        // 1. USERS
        // ============================================
        DB::table('users')->insert([
            ['user_id' => 1, 'username' => 'saad.m', 'email' => 'saad.m@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Admin', 'created_at' => '2026-01-05 09:00:00'],
            ['user_id' => 2, 'username' => 'amina.i', 'email' => 'amina.i@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Admin', 'created_at' => '2026-01-05 09:05:00'],
            ['user_id' => 3, 'username' => 'taufeeq.u', 'email' => 'taufeeq.u@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-05 09:10:00'],
            ['user_id' => 4, 'username' => 'hassan.k', 'email' => 'hassan.k@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-06 10:00:00'],
            ['user_id' => 5, 'username' => 'fatima.r', 'email' => 'fatima.r@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-06 10:15:00'],
            ['user_id' => 6, 'username' => 'ali.zaman', 'email' => 'ali.zaman@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-07 11:00:00'],
            ['user_id' => 7, 'username' => 'sara.n', 'email' => 'sara.n@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-07 11:20:00'],
            ['user_id' => 8, 'username' => 'usman.t', 'email' => 'usman.t@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Guest', 'created_at' => '2026-01-08 12:00:00'],
            ['user_id' => 9, 'username' => 'zainab.q', 'email' => 'zainab.q@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Guest', 'created_at' => '2026-01-08 12:30:00'],
            ['user_id' => 10, 'username' => 'bilal.h', 'email' => 'bilal.h@uet.edu.pk', 'password_hash' => Hash::make('password123'), 'user_type' => 'Member', 'created_at' => '2026-01-09 13:00:00'],
            ['user_id' => 11, 'username' => 'muhammadsaad', 'email' => 'msamk2003@gmail.com', 'password_hash' => Hash::make('password123'), 'user_type' => 'Admin', 'created_at' => '2026-06-26 01:46:51'],
        ]);

        // ============================================
        // 2. WORKSPACES
        // ============================================
        DB::table('workspaces')->insert([
            ['workspace_id' => 1, 'workspace_name' => 'UET-CSE-Spring2026', 'creator_id' => 1, 'created_at' => '2026-01-05 09:30:00'],
            ['workspace_id' => 2, 'workspace_name' => 'FYP-Group27-Research', 'creator_id' => 2, 'created_at' => '2026-01-06 14:00:00'],
            ['workspace_id' => 3, 'workspace_name' => 'GTA 6', 'creator_id' => 11, 'created_at' => '2026-06-26 01:46:51'],
        ]);

        // ============================================
        // 3. WORKSPACE MEMBERSHIPS
        // ============================================
        DB::table('workspace_memberships')->insert([
            ['membership_id' => 1, 'user_id' => 1, 'workspace_id' => 1, 'role' => 'Admin', 'joined_at' => '2026-01-05 09:30:00'],
            ['membership_id' => 2, 'user_id' => 2, 'workspace_id' => 1, 'role' => 'Admin', 'joined_at' => '2026-01-05 09:35:00'],
            ['membership_id' => 3, 'user_id' => 3, 'workspace_id' => 1, 'role' => 'Member', 'joined_at' => '2026-01-05 09:40:00'],
            ['membership_id' => 4, 'user_id' => 4, 'workspace_id' => 1, 'role' => 'Member', 'joined_at' => '2026-01-06 10:05:00'],
            ['membership_id' => 5, 'user_id' => 5, 'workspace_id' => 1, 'role' => 'Member', 'joined_at' => '2026-01-06 10:20:00'],
            ['membership_id' => 6, 'user_id' => 6, 'workspace_id' => 1, 'role' => 'Member', 'joined_at' => '2026-01-07 11:05:00'],
            ['membership_id' => 7, 'user_id' => 8, 'workspace_id' => 1, 'role' => 'Guest', 'joined_at' => '2026-01-08 12:05:00'],
            ['membership_id' => 8, 'user_id' => 2, 'workspace_id' => 2, 'role' => 'Admin', 'joined_at' => '2026-01-06 14:00:00'],
            ['membership_id' => 9, 'user_id' => 3, 'workspace_id' => 2, 'role' => 'Member', 'joined_at' => '2026-01-06 14:10:00'],
            ['membership_id' => 10, 'user_id' => 7, 'workspace_id' => 2, 'role' => 'Member', 'joined_at' => '2026-01-07 11:25:00'],
            ['membership_id' => 11, 'user_id' => 9, 'workspace_id' => 2, 'role' => 'Guest', 'joined_at' => '2026-01-08 12:35:00'],
            ['membership_id' => 12, 'user_id' => 10, 'workspace_id' => 1, 'role' => 'Member', 'joined_at' => '2026-01-09 13:05:00'],
            ['membership_id' => 13, 'user_id' => 11, 'workspace_id' => 3, 'role' => 'Admin', 'joined_at' => '2026-06-26 01:46:51'],
        ]);

        // ============================================
        // 4. CHANNELS
        // ============================================
        DB::table('channels')->insert([
            ['channel_id' => 1, 'workspace_id' => 1, 'channel_name' => 'general', 'channel_type' => 'Public', 'created_at' => '2026-01-05 09:31:00'],
            ['channel_id' => 2, 'workspace_id' => 1, 'channel_name' => 'project-announcements', 'channel_type' => 'Public', 'created_at' => '2026-01-05 09:32:00'],
            ['channel_id' => 3, 'workspace_id' => 1, 'channel_name' => 'core-team-private', 'channel_type' => 'Private', 'created_at' => '2026-01-06 10:30:00'],
            ['channel_id' => 4, 'workspace_id' => 2, 'channel_name' => 'fyp-general', 'channel_type' => 'Public', 'created_at' => '2026-01-06 14:01:00'],
            ['channel_id' => 5, 'workspace_id' => 2, 'channel_name' => 'fyp-budget-private', 'channel_type' => 'Private', 'created_at' => '2026-01-06 14:05:00'],
            ['channel_id' => 6, 'workspace_id' => 1, 'channel_name' => 'random', 'channel_type' => 'Public', 'created_at' => '2026-01-07 11:30:00'],
            ['channel_id' => 7, 'workspace_id' => 3, 'channel_name' => 'GTA 6 Pre-Order', 'channel_type' => 'Private', 'created_at' => '2026-06-26 01:46:51'],
            ['channel_id' => 8, 'workspace_id' => 3, 'channel_name' => 'PS5 Games', 'channel_type' => 'Private', 'created_at' => '2026-06-26 01:46:51'],
        ]);

        // ============================================
        // 5. MESSAGES
        // ============================================
        DB::table('messages')->insert([
            ['message_id' => 1, 'channel_id' => 1, 'author_id' => 1, 'parent_message_id' => null, 'content' => 'Welcome to the Internal Team Communication Portal!', 'is_pinned' => 1, 'pinned_at' => '2026-01-05 09:33:00', 'created_at' => '2026-01-05 09:33:00', 'edited_at' => null],
            ['message_id' => 2, 'channel_id' => 1, 'author_id' => 3, 'parent_message_id' => 1, 'content' => 'Thanks! Excited to get started.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-05 09:40:00', 'edited_at' => null],
            ['message_id' => 3, 'channel_id' => 2, 'author_id' => 2, 'parent_message_id' => null, 'content' => 'Milestone 1 is due this Friday.', 'is_pinned' => 1, 'pinned_at' => '2026-01-05 09:46:00', 'created_at' => '2026-01-05 09:45:00', 'edited_at' => null],
            ['message_id' => 4, 'channel_id' => 2, 'author_id' => 4, 'parent_message_id' => 3, 'content' => 'Noted, will start the ERD today.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-06 10:10:00', 'edited_at' => null],
            ['message_id' => 5, 'channel_id' => 2, 'author_id' => 5, 'parent_message_id' => 3, 'content' => 'Same here, syncing with Taufeeq on the EERD part.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-06 10:25:00', 'edited_at' => null],
            ['message_id' => 6, 'channel_id' => 3, 'author_id' => 1, 'parent_message_id' => null, 'content' => 'Core team: please review the normalization draft before submission.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-06 10:35:00', 'edited_at' => null],
            ['message_id' => 7, 'channel_id' => 3, 'author_id' => 2, 'parent_message_id' => 6, 'content' => 'Reviewed, 3NF looks solid. Added two notes on MESSAGE and TASKITEM.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-06 10:50:00', 'edited_at' => null],
            ['message_id' => 8, 'channel_id' => 4, 'author_id' => 2, 'parent_message_id' => null, 'content' => 'FYP kickoff: topic finalized as Internal Team Communication Portal.', 'is_pinned' => 1, 'pinned_at' => '2026-01-06 14:02:00', 'created_at' => '2026-01-06 14:02:00', 'edited_at' => null],
            ['message_id' => 9, 'channel_id' => 4, 'author_id' => 7, 'parent_message_id' => 8, 'content' => 'Great, I will start drafting the literature review.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-07 11:26:00', 'edited_at' => null],
            ['message_id' => 10, 'channel_id' => 5, 'author_id' => 2, 'parent_message_id' => null, 'content' => 'Budget for cloud storage needs sign-off by Monday.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-06 14:06:00', 'edited_at' => null],
            ['message_id' => 11, 'channel_id' => 6, 'author_id' => 6, 'parent_message_id' => null, 'content' => 'Anyone up for a study session this weekend?', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-07 11:31:00', 'edited_at' => null],
            ['message_id' => 12, 'channel_id' => 6, 'author_id' => 7, 'parent_message_id' => 11, 'content' => 'I am in, library at 4 PM?', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-07 11:35:00', 'edited_at' => null],
            ['message_id' => 13, 'channel_id' => 1, 'author_id' => 10, 'parent_message_id' => null, 'content' => 'Hi all, just joined the workspace.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-09 13:06:00', 'edited_at' => null],
            ['message_id' => 14, 'channel_id' => 2, 'author_id' => 1, 'parent_message_id' => null, 'content' => 'Reminder: upload your Milestone 2 docx by tonight.', 'is_pinned' => 1, 'pinned_at' => '2026-01-09 18:00:00', 'created_at' => '2026-01-09 17:55:00', 'edited_at' => null],
            ['message_id' => 15, 'channel_id' => 2, 'author_id' => 6, 'parent_message_id' => 14, 'content' => 'Uploaded, please check the schema diagram attachment.', 'is_pinned' => 0, 'pinned_at' => null, 'created_at' => '2026-01-09 18:10:00', 'edited_at' => null],
        ]);

        // ============================================
        // 6. FILE ATTACHMENTS
        // ============================================
        DB::table('file_attachments')->insert([
            ['attachment_id' => 1, 'message_id' => 7, 'file_name' => 'normalization_notes.pdf', 'file_url' => 'https://files.itcp.local/a1', 'storage_key' => 'key_a1', 'mime_type' => 'application/pdf', 'file_size_bytes' => 482133, 'uploaded_at' => '2026-01-06 10:51:00'],
            ['attachment_id' => 2, 'message_id' => 9, 'file_name' => 'literature_review_v1.docx', 'file_url' => 'https://files.itcp.local/a2', 'storage_key' => 'key_a2', 'mime_type' => 'application/msword', 'file_size_bytes' => 201044, 'uploaded_at' => '2026-01-07 11:27:00'],
            ['attachment_id' => 3, 'message_id' => 10, 'file_name' => 'cloud_budget_estimate.xlsx', 'file_url' => 'https://files.itcp.local/a3', 'storage_key' => 'key_a3', 'mime_type' => 'application/excel', 'file_size_bytes' => 88210, 'uploaded_at' => '2026-01-06 14:07:00'],
            ['attachment_id' => 4, 'message_id' => 15, 'file_name' => 'relational_schema_v2.docx', 'file_url' => 'https://files.itcp.local/a4', 'storage_key' => 'key_a4', 'mime_type' => 'application/msword', 'file_size_bytes' => 412980, 'uploaded_at' => '2026-01-09 18:11:00'],
            ['attachment_id' => 5, 'message_id' => 15, 'file_name' => 'schema_diagram.png', 'file_url' => 'https://files.itcp.local/a5', 'storage_key' => 'key_a5', 'mime_type' => 'image/png', 'file_size_bytes' => 733500, 'uploaded_at' => '2026-01-09 18:11:30'],
            ['attachment_id' => 6, 'message_id' => 6, 'file_name' => 'draft_checklist.pdf', 'file_url' => 'https://files.itcp.local/a6', 'storage_key' => 'key_a6', 'mime_type' => 'application/pdf', 'file_size_bytes' => 56230, 'uploaded_at' => '2026-01-06 10:36:00'],
            ['attachment_id' => 7, 'message_id' => 3, 'file_name' => 'milestone1_template.docx', 'file_url' => 'https://files.itcp.local/a7', 'storage_key' => 'key_a7', 'mime_type' => 'application/msword', 'file_size_bytes' => 97650, 'uploaded_at' => '2026-01-05 09:47:00'],
            ['attachment_id' => 8, 'message_id' => 12, 'file_name' => 'study_room_booking.pdf', 'file_url' => 'https://files.itcp.local/a8', 'storage_key' => 'key_a8', 'mime_type' => 'application/pdf', 'file_size_bytes' => 30200, 'uploaded_at' => '2026-01-07 11:36:00'],
        ]);

        // ============================================
        // 7. TASK ITEMS
        // ============================================
        DB::table('task_items')->insert([
            ['task_id' => 1, 'channel_id' => 2, 'message_id' => 3, 'assignee_id' => 4, 'creator_id' => 2, 'description' => 'Complete ERD for Milestone 1', 'status' => 'Completed', 'due_date' => '2026-01-09', 'created_at' => '2026-01-05 09:46:30'],
            ['task_id' => 2, 'channel_id' => 2, 'message_id' => 3, 'assignee_id' => 5, 'creator_id' => 2, 'description' => 'Draft EERD specialization hierarchies', 'status' => 'Completed', 'due_date' => '2026-01-09', 'created_at' => '2026-01-05 09:47:00'],
            ['task_id' => 3, 'channel_id' => 3, 'message_id' => 6, 'assignee_id' => 2, 'creator_id' => 1, 'description' => 'Review normalization draft (1NF-3NF)', 'status' => 'Completed', 'due_date' => '2026-01-06', 'created_at' => '2026-01-06 10:36:30'],
            ['task_id' => 4, 'channel_id' => 4, 'message_id' => 8, 'assignee_id' => 7, 'creator_id' => 2, 'description' => 'Write FYP literature review section', 'status' => 'In Progress', 'due_date' => '2026-01-14', 'created_at' => '2026-01-06 14:03:00'],
            ['task_id' => 5, 'channel_id' => 5, 'message_id' => 10, 'assignee_id' => 2, 'creator_id' => 2, 'description' => 'Get cloud storage budget sign-off', 'status' => 'Open', 'due_date' => '2026-01-12', 'created_at' => '2026-01-06 14:06:30'],
            ['task_id' => 6, 'channel_id' => 2, 'message_id' => 14, 'assignee_id' => 6, 'creator_id' => 1, 'description' => 'Upload final Milestone 2 docx', 'status' => 'Completed', 'due_date' => '2026-01-09', 'created_at' => '2026-01-09 17:56:00'],
            ['task_id' => 7, 'channel_id' => 2, 'message_id' => 14, 'assignee_id' => 3, 'creator_id' => 1, 'description' => 'Prepare Milestone 3 SQL implementation', 'status' => 'In Progress', 'due_date' => '2026-01-16', 'created_at' => '2026-01-09 17:56:30'],
            ['task_id' => 8, 'channel_id' => 6, 'message_id' => 11, 'assignee_id' => 7, 'creator_id' => 6, 'description' => 'Reserve library study room for weekend', 'status' => 'Completed', 'due_date' => '2026-01-10', 'created_at' => '2026-01-07 11:32:00'],
            ['task_id' => 9, 'channel_id' => 1, 'message_id' => 1, 'assignee_id' => 3, 'creator_id' => 1, 'description' => 'Set up workspace onboarding guide', 'status' => 'Open', 'due_date' => '2026-01-15', 'created_at' => '2026-01-05 09:34:00'],
            ['task_id' => 10, 'channel_id' => 4, 'message_id' => 9, 'assignee_id' => 4, 'creator_id' => 7, 'description' => 'Cross-check literature review citations', 'status' => 'Open', 'due_date' => '2026-01-17', 'created_at' => '2026-01-07 11:28:00'],
        ]);

        // ============================================
        // 8. ADMIN USERS
        // ============================================
        DB::table('admin_users')->insert([
            ['user_id' => 1, 'can_invite' => 1, 'admin_since' => '2026-01-05 09:00:00'],
            ['user_id' => 2, 'can_invite' => 1, 'admin_since' => '2026-01-05 09:05:00'],
            ['user_id' => 11, 'can_invite' => 1, 'admin_since' => '2026-06-26 01:46:51'],
        ]);

        // ============================================
        // 9. GUEST USERS
        // ============================================
        DB::table('guest_users')->insert([
            ['user_id' => 8, 'invited_by' => 1, 'guest_expires_at' => '2026-02-08 12:00:00'],
            ['user_id' => 9, 'invited_by' => 2, 'guest_expires_at' => '2026-02-08 12:30:00'],
        ]);

        // ============================================
        // 10. PUBLIC CHANNELS
        // ============================================
        DB::table('public_channels')->insert([
            ['channel_id' => 1, 'is_default' => 1],
            ['channel_id' => 2, 'is_default' => 0],
            ['channel_id' => 4, 'is_default' => 1],
            ['channel_id' => 6, 'is_default' => 0],
        ]);

        // ============================================
        // 11. PRIVATE CHANNELS
        // ============================================
        DB::table('private_channels')->insert([
            ['channel_id' => 3, 'invite_only' => 1],
            ['channel_id' => 5, 'invite_only' => 1],
            ['channel_id' => 7, 'invite_only' => 1],
            ['channel_id' => 8, 'invite_only' => 1],
        ]);

        // ============================================
        // 12. PRIVATE CHANNEL MEMBERSHIPS
        // ============================================
        DB::table('private_channel_memberships')->insert([
            ['pcm_id' => 1, 'channel_id' => 3, 'user_id' => 1, 'invited_by' => 1, 'joined_at' => '2026-01-06 10:30:00'],
            ['pcm_id' => 2, 'channel_id' => 3, 'user_id' => 2, 'invited_by' => 1, 'joined_at' => '2026-01-06 10:31:00'],
            ['pcm_id' => 3, 'channel_id' => 3, 'user_id' => 6, 'invited_by' => 1, 'joined_at' => '2026-01-07 11:06:00'],
            ['pcm_id' => 4, 'channel_id' => 5, 'user_id' => 2, 'invited_by' => 2, 'joined_at' => '2026-01-06 14:05:00'],
            ['pcm_id' => 5, 'channel_id' => 5, 'user_id' => 3, 'invited_by' => 2, 'joined_at' => '2026-01-06 14:11:00'],
            ['pcm_id' => 6, 'channel_id' => 7, 'user_id' => 11, 'invited_by' => 11, 'joined_at' => '2026-06-26 01:46:51'],
            ['pcm_id' => 7, 'channel_id' => 8, 'user_id' => 11, 'invited_by' => 11, 'joined_at' => '2026-06-26 01:46:51'],
        ]);

        $this->command->info('✅ Database seeded successfully!');
    }
}