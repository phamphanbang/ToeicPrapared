<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Test;
use App\Models\PartTemplate;

class TestTemplate extends Model
{
    use HasFactory;

    protected $table = "test_template";
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'num_of_question',
        'num_of_part',
        'duration',
        'have_score_range'
    ];

    public function tests() {
        return $this->hasMany(Test::class,'test_type_id');
    }

    public function partTemplates() {
        return $this->hasMany(PartTemplate::class,'test_id');
    }

    public function scopeGetAllTemplates($query){
        return $query->paginate(5);
    }
}
