<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSting extends Model
{
    use HasFactory;
    protected $table = "transaction_sting";

    public $primaryKey = "ID_TRANSACTION";

    protected $keyType = 'string';
    public $timestamps = true;

    public function sting(){
        return $this->belongsTo(Sting::class,"ID_STING","ID_STING");
    }

    public function farmer(){
        //ini buyernya
        return $this->belongsTo(User::class,"EMAIL_FARMER","EMAIL");
    }
}
