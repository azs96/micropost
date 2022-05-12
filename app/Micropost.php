<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // このポストをお気に入りしたユーザ
    public function users_who_favored()
    {
        return $this->belongsToMany(User::user, 'favorites', 'micropost_id', 'user_id')->withTimestamps();
    }
}
