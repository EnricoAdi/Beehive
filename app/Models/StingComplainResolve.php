<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StingComplainResolve extends Model
{
    use HasFactory;
    protected $table = "sting_complain_resolve";

    public $primaryKey = "ID_COMPLAIN";
    public $timestamps = true;

    public function transaction(){
        return $this->belongsTo(TransactionSting::class,"ID_TRANSACTION","ID_TRANSACTION");
    }
}
