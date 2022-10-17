<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PartTemplate;

class ClusterTemplate extends Model
{
    use HasFactory;

    protected $table = "cluster_template";

    protected $fillable = [
        'num_in_part',
        'num_of_question',
    ];

    public function partTemplate() {
        $this->belongsTo(PartTemplate::class,'part_id');
    }

}
