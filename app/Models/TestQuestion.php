<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TestPart;
use App\Models\TestCluster;
use App\Models\TestHistoryAnswer;

class TestQuestion extends Model
{
    use HasFactory;

    protected $table = "test_question";
    public $timestamps = false;

    protected $fillable = [
        'order_in_test',
        'question',
        'attachment',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answer',
        'explaination'
    ];

    public function testPart() {
        return $this->belongsTo(TestPart::class,'part_id');
    }

    public function testCluster() {
        return $this->belongsTo(TestCluster::class,'cluster_id');
    }

    public function testHistoryAnswer() {
        return $this->hasMany(TestHistoryAnswer::class,'question_id');
    }
}
