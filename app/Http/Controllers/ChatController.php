<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Http\Requests\MessageRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages(Room $room)
    {
        return response()->json($room->messages()->orderBy('id', 'desc')->get());
    }

    public function storeMessage(MessageRequest $request)
    {
        $data = $request->only(['content', 'room_id']);

        if($request->user_id){

            $room = Room::create([
                'active' => 1,
            ]);

            $room->users()->sync([auth()->user()->id, $request->user_id]);
            $data['room_id'] = $room->id;

        }

        $message = Auth::user()->messages()->create($data);

        event(new NewMessage($message));

        return response()->json($message);
    }

}
