<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\CommentSet;

class Blog extends Model
{
    use HasFactory;

    protected $table = "blog";

    protected $fillable = [
        'name',
        'blog',
        'banner'
    ];

    public function user() {
        return  $this->belongsTo(User::class,'user_id');
    }

    public function commentSet() {
        return  $this->belongsTo(CommentSet::class,'comment_set_id');
    }

    public function scopeGetAllBlogs($query){
        return $query->paginate(5);
    }
}
