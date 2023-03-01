<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'is_mandatory',
        'answers',
        'correct_answers',
        'quiz_id',
    ];

    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }
}
