<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingUser extends Model
{
    use HasFactory;

    protected $table = 'betting_user';

    protected $primaryKey = 'beu_id';

    public $timestamps = false;

    protected $fillable = [
        'beu_id',
        'beu_key_number',
        'beu_key_blaze',
        'beu_username',
        'beu_rank',
        'beu_level'
    ];
}
