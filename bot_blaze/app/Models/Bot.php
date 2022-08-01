<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $table = 'bot';

    protected $primaryKey = 'bot_id';

    protected $fillable = [
        'bot_id',
        'bot_token',
        'bot_key',
        'bot_name',
        'bot_username',
        'bot_active'
    ];
}
