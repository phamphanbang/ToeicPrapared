<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TrainingHistory;
use App\Models\User;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $table = "training_plan";

    protected $fillable = [
        'status',
        'initial_score',
        'current_score',
        'goal_score',
        'score_between_test',
        'time_between_test',
        'date_start',
        'date_end_goal',
        'date_end'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function trainingHistory() {
        return $this->hasMany(TrainingHistory::class,'plan_id');
    }
}
