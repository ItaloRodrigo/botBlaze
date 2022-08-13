<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    use HasFactory;

    protected $table = 'game_type';

    protected $primaryKey = 'gat_id';

    public $timestamps = false;

    protected $fillable = [
        'gat_id',
        'gat_name',
        'gat_created',
    ];
}
