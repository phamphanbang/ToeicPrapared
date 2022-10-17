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
    ];

    public function user() {
        $this->belongsTo(User::class,'user_id');
    }

    public function commentSet() {
        $this->belongsTo(CommentSet::class,'comment_set_id');
    }
}
