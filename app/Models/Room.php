<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['active'];
    protected $appends = ['user'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getUserAttribute()
    {
        if(!auth()->check()) return [];

        $user = $this->users()->where('users.id', '<>', auth()->user()->id)->first();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
