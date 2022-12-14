<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Test;
use App\Models\TestHistoryAnswer;
use App\Models\TrainingTest;
use App\Models\User;

class TestHistory extends Model
{
    use HasFactory;

    protected $table = "test_history";

    protected $fillable = [
        'duration',
        'score'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function test() {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function trainingTest() {
        return $this->hasMany(TrainingTest::class,'test_history_id');
    }

    public function testHistoryAnswer() {
        return $this->hasMany(TestHistoryAnswer::class,'hsitory_id');
    }
}
