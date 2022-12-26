<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatSting extends Model
{
    use HasFactory; use SoftDeletes;
    protected $table = "chat_sting";
    public $primaryKey = "ID_CHAT";

    public $timestamps = true;

    public function author(){
        return $this->belongsTo(User::class, "EMAIL", "EMAIL");
    }
    public function complain(){
        return $this->belongsTo(StingComplainResolve::class,
        "ID_COMPLAIN", "ID_COMPLAIN");
    }
    public function transaction(){
        return $this->belongsTo(TransactionSting::class,
        "ID_TRANSACTION", "ID_TRANSACTION");
    }
    public function lelang(){
        return $this->belongsTo(LelangSting::class,
        "ID_TRANSACTION", "ID_LELANG_STING");
    }
    public function reply(){
        return $this->belongsTo(ChatSting::class, "REPLY_TO", "ID_CHAT");
    }

}
