<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TestPart;
use App\Models\TestQuestion;

class TestCluster extends Model
{
    use HasFactory;

    protected $table = "test_cluster";

    protected $fillable = [
        'order_in_part',
        'question_begin',
        'question_end',
        'question',
        'attachment'
    ];

    public function testPart() {
        return $this->belongsTo(TestPart::class,'part_id');
    }

    public function testQuestion() {
        return $this->hasMany(TestQuestion::class,'cluster_id');
    }
}
