<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'user_id',
        'status',
        'country',
        'arrival_date',
        'departure_date',
        'description',
        'counts',
        'activity_id'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
    public function activity(){
        $this->belongsTo(Activity::class);
}
}
