<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
    protected $fillable = [
        'user_id', 'title', 'description','category',
    ];
}
