<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageBot extends Model
{
    use HasFactory;

    protected $table = 'message_bot';

    protected $primaryKey = 'mes_id';

    public $timestamps = false;

    protected $fillable = [
        'mes_id',
        'mes_bot_id',
        'mes_cha_id',
        'mes_update_id',
        'mes_text'
    ];
}
