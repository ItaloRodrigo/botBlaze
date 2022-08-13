<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatisticsUser extends Model
{
    use HasFactory;

    protected $table = 'statistics_user';

    public $timestamps = false;

    protected $fillable = [
        'stu_beu_id',
        'stu_gat_id',
        'stu_total_bets',
        'stu_total_bets_won',
        'stu_total_bets_lost',
        'stu_updated',
    ];
}
