<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserValidation extends Model
{
    use HasFactory;
    protected $table = "user_validation";

    public $timestamps = true;
    public function user(){
        return $this->belongsTo(User::class,"EMAIL","EMAIL");
    }
}
