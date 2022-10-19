<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TrainingHistory;
use App\Models\Test;
use App\Models\TestHistory;

class TrainingTest extends Model
{
    use HasFactory;

    protected $table = "training_test";

    protected $fillable = [
        'type',
    ];

    public function trainingHistory() {
        return $this->belongsTo(TrainingHistory::class,'training_history_id');
    }

    public function test() {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function testHistory() {
        return $this->belongsTo(TestHistory::class,'test_history_id');
    }
}
