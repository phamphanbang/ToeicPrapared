<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TrainingPlan;
use App\Models\TrainingTest;

class TrainingHistory extends Model
{
    use HasFactory;

    protected $table = "training_history";

    protected $fillable = [
        'status',
        'current_score',
        'date_start',
        'date_end'
    ];

    public function trainingPlan() {
        $this->belongsTo(TrainingPlan::class,'plan_id');
    }

    public function trainingTest() {
        $this->hasMany(TrainingTest::class,'training_history_id');
    }
}
