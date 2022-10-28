<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TestTemplate;
use App\Models\ClusterTemplate;

class PartTemplate extends Model
{
    use HasFactory;

    protected $table = "part_template";
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'order_in_test',
        'num_of_question',
        'have_cluster'
    ];

    public function testTemplate() {
        return $this->belongsTo(TestTemplate::class,'test_id');
    }

    public function clusterTemplate() {
        return $this->hasMany(ClusterTemplate::class,'part_id');
    }
}
