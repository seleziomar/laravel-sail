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
        $rooms = $user->rooms()->with('user')->get();

        $rooms_id = $rooms->pluck('id')->toArray();

        $model = new User();
        $users = $model->chat_contact($rooms_id, $user);

        return view('home', compact('rooms', 'users', 'user'));
    }
}
