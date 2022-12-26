<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StingMedia extends Model
{
    use HasFactory;
    protected $table = "sting_media";

    public $primaryKey = "ID_STING_MEDIA";

    public $timestamps = true;
    public function sting(){
        return $this->belongsTo(Sting::class,"ID_STING","ID_STING");
    }
}
