<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PartTemplate;

class ClusterTemplate extends Model
{
    use HasFactory;

    protected $table = "cluster_template";
    public $timestamps = false;

    protected $fillable = [
        'num_in_part',
        'num_of_question',
    ];

    public function partTemplate() {
        return  $this->belongsTo(PartTemplate::class,'part_id');
    }

}
