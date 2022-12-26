<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangSting extends Model
{
    use HasFactory;
    protected $table = "lelang_sting";

    public $primaryKey = "ID_LELANG_STING";

    protected $keyType = 'string';
    public $timestamps = true;


    public function farmer(){
        //ini buyernya
        return $this->belongsTo(User::class,"EMAIL_FARMER","EMAIL");
    }
    public function beeworker(){
        return $this->belongsTo(User::class,"EMAIL_BEEWORKER","EMAIL");
    }

    public function lelang_category(){
        return $this->hasMany(LelangStingCategory::class,"ID_LELANG_STING","ID_LELANG_STING");
    }
}
