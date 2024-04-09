<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnTrip extends Model
{
    use HasFactory;
    protected $fillable=[
        'trip_type',
        'member_count',
        'number_of_days',
        'arrival_date',
        'description',
        'user_id',
        'country',
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
