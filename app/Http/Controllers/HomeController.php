<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $usersNot = [$user->id];
        $rooms = $user->rooms()->get();

        foreach($rooms as $room){
            $usersNot[] = $room->user['id'];
        }

        $users = User::whereNotIn('id', $usersNot)->get();
        return view('home', compact('rooms', 'users', 'user'));
    }
}
