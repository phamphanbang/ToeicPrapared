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
    public $timestamps = false;

    protected $fillable = [
        'status',
        'current_score',
        'goal_score',
        'date_end',
        'part_suggestion'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

}
