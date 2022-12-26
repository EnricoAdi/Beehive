<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StingCategory extends Model
{
    use HasFactory;
    protected $table = "sting_category";


    public $primaryKey = "ID_STINGCATEGORY";

    public $timestamps = true;

    public function category(){
        return $this->hasOne(Category::class,"ID_CATEGORY","ID_CATEGORY");
    }
}
