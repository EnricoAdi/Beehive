<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    protected $table = "top_up";
    public $primaryKey = "KODE_TOPUP";

    protected $keyType = 'string';
    public $timestamps = true;
    public function user(){
        return $this->belongsTo(User::class,"EMAIL","EMAIL");
    }
}
