<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProtalRecall extends Model
{
    use HasFactory;

    protected $table = 'master_protal_recalls';

    protected $fillable = [
        'user_id',
        'protal_id',
        'amount',
        'date',
        'auth_id',
        'transaction_id',
        'remarks',
    ];
}
