<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangStingCategory extends Model
{
    use HasFactory;

    protected $table = "lelang_sting_category";
    public $primaryKey = "ID_LELANGSTINGCATEGORY";

    public $timestamps = true;

    public function category(){
        return $this->hasOne(Category::class,"ID_CATEGORY","ID_CATEGORY");
    }
}
