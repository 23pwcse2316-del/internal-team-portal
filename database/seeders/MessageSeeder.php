<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run()
    {
        // Add sample messages for the "GTA 6 Pre-Order" channel
        // First, find the channel ID (replace with your actual channel ID)
        $channelId = 1; // CHANGE THIS TO YOUR CHANNEL ID
        
        DB::table('messages')->insert([
            [
                'message_id' => 100,
                'channel_id' => $channelId,
                'author_id' => 11, // CHANGE TO YOUR USER ID
                'parent_message_id' => null,
                'content' => 'Welcome to the GTA 6 Pre-Order channel! 🎮',
                'is_pinned' => 1,
                'pinned_at' => now(),
                'created_at' => now(),
            ],
            [
                'message_id' => 101,
                'channel_id' => $channelId,
                'author_id' => 11,
                'parent_message_id' => null,
                'content' => 'Has anyone pre-ordered yet? I\'m thinking of getting the Collector\'s Edition.',
                'is_pinned' => 0,
                'pinned_at' => null,
                'created_at' => now(),
            ],
            [
                'message_id' => 102,
                'channel_id' => $channelId,
                'author_id' => 11,
                'parent_message_id' => 101,
                'content' => 'The Collector\'s Edition comes with a steelbook and a map! Definitely worth it.',
                'is_pinned' => 0,
                'pinned_at' => null,
                'created_at' => now(),
            ],
        ]);
    }
}