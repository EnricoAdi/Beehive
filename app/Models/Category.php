<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory; use SoftDeletes;
    protected $table = "category";
    public $primaryKey = "ID_CATEGORY";

    public $timestamps = true;
    public function stingsRelated(){
        return $this->belongsToMany(Sting::class,
        "sting_category",
        "ID_CATEGORY","ID_STING");
    }
}
