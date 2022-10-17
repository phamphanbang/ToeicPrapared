<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\CommentSet;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comment";

    protected $fillable = [
        'comment',
    ];

    public function commentSet() {
        $this->belongsTo(CommentSet::class,'comment_set_id');
    }

    public function user() {
        $this->belongsTo(User::class,'user_id');
    }
}
