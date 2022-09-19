<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Room::first() == null){
            $room = Room::create(['active' => 1]);
        }

        Message::factory(5)->create();

    }
}
