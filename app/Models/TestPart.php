<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Test;
use App\Models\TestCluster;
use App\Models\TestQuestion;

class TestPart extends Model
{
    use HasFactory;

    protected $table = "test_part";
    public $timestamps = false;

    protected $fillable = [
        'order_in_test',
        'num_of_question',
        'name',
        'have_cluster'
    ];

    public function test() {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function testCluster() {
        return $this->hasMany(TestCluster::class,'part_id');
    }

    public function testQuestions() {
        return $this->hasMany(TestQuestion::class,'part_id');
    }
}
