<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TestHistory;
use App\Models\TestQuestion;

class TestHistoryAnswer extends Model
{
    use HasFactory;

    protected $table = "test_history_answer";
    public $timestamps = false;

    protected $fillable = [
        'answer',
    ];

    public function testHisory() {
        return $this->belongsTo(TestHistory::class,'history_id');
    }

    public function testQuestion() {
        return $this->belongsTo(TestQuestion::class,'question_id');
    }
}
