<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'content', 'room_id'];
    protected $appends = ['avatar'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getAvatarAttribute()
    {
        if(auth()->check()){

            $name = auth()->user()->name;

            return $name[0];

        }

        return 'A';
    }
}
