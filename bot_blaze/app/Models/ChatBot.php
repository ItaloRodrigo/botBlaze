<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBot extends Model
{
    use HasFactory;

    protected $table = 'chat_bot';

    protected $primaryKey = 'cha_id';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'cha_id',
        'cha_bot_id',
        'cha_key',
        'cha_firstname',
        'cha_lastname',
        'cha_type',
        'cha_boot'
    ];
}
