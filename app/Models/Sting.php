<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sting extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "sting";

    public $primaryKey = "ID_STING";

    protected $keyType = 'string';
    public $timestamps = true;

    public function media(){
        return $this->hasMany(StingMedia::class,"ID_STING","ID_STING");
    }

    public function author(){
        return $this->belongsTo(User::class, "EMAIL_BEEWORKER", "EMAIL");
    }

    public function hasTransaction(){
        return $this->hasMany(TransactionSting::class, "ID_STING", "ID_STING");
    }

    public function doneTransaction(){
        return $this->hasMany(TransactionSting::class, "ID_STING",
         "ID_STING")->where("STATUS","3");
    }


    public function sting_category(){
        return $this->hasMany(StingCategory::class,"ID_STING","ID_STING");
    }
}
