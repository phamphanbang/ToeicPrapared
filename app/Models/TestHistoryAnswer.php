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

    protected $fillable = [
        'answer',
    ];

    public function testHisory() {
        $this->belongsTo(TestHistory::class,'history_id');
    }

    public function testQuestion() {
        $this->belongsTo(TestQuestion::class,'question_id');
    }
}