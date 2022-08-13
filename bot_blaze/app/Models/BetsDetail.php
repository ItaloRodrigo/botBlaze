<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetsDetail extends Model
{
    use HasFactory;

    protected $table = 'bets_detail';

    protected $primaryKey = 'bet_id';

    public $timestamps = false;

    protected $fillable = [
        'bet_id',
        'bet_his_id',
        'bet_beu_id',
        'bet_key_blaze',
        'bet_cashed_out_at',
        'bet_amount',
        'bet_win_amount',
        'bet_status'
    ];
}
