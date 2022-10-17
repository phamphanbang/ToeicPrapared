<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TrainingTest;
use App\Models\TestHistory;
use App\Models\CommentSet;
use App\Models\TestTemplate;
use App\Models\TestPart;

class Test extends Model
{
    use HasFactory;

    protected $table = "test";

    protected $fillable = [
        'name',
        'status',
        'score_range'
    ];

    public function trainingTests() {
        $this->hasMany(TrainingTest::class,'test_id');
    }

    public function testHistories() {
        $this->hasMany(TestHistory::class,'test_id');
    }

    public function testParts() {
        $this->hasMany(TestPart::class,'test_id');
    }

    public function testTemplate() {
        $this->belongsTo(TestTemplate::class,'test_type_id');
    }

    public function commentSet() {
        $this->belongsTo(CommentSet::class,'comment_set_id');
    }
}
