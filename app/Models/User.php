<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\TrainingPlan;
use App\Models\TestHistory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $table = "user";

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs() {
        $this->hasMany(Blog::class,'user_id');
    }

    public function comments() {
        $this->hasMany(Comment::class,'user_id');
    }

    public function plans() {
        $this->hasMany(TrainingPlan::class,'user_id');
    }

    public function testHistories() {
        $this->hasMany(TestHistory::class,'user_id');
    }

    public function scopeGetAllUsers($query){
        return $query->paginate(5);
    }
}
