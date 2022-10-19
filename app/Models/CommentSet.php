<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Test;

class CommentSet extends Model
{
    use HasFactory;

    protected $table = "comment_set";
    public $timestamps = false;

    protected $fillable = [
        'type',
    ];

    public function blog() {
        return $this->hasOne(Blog::class,'comment_set_id');
    }

    public function test() {
        return  $this->hasOne(Test::class,'comment_set_id');
    }

    public function comments() {
        $this->hasMany(Comment::class,'comment_set_id');
    }
}
