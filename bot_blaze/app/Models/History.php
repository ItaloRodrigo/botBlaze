<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $primaryKey = 'his_id';

    public $timestamps = false;

    protected $fillable = [
        'his_id',
        'his_key_blaze',
        'his_crash_point',
        'his_created',
        'his_total_bets_placed'
    ];
}
