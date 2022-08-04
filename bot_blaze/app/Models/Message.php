<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'message';

    protected $primaryKey = 'mes_id';

    public $timestamps = false;

    protected $fillable = [
        'mes_id',
        'mes_cha_id',
        'cha_key',
        'mes_text',
        'mes_created'
    ];
}
