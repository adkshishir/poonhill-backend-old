<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'introduction',
        'itinerary',
        'includes',
        'good_to_know',
        'images',
        'vedio',
        'price',
        'duration',
        'altitude',
        'start_from',
        'end_at',
        'attraction',
        'rating',
        'culture',
        'food',
        'transportation',
        'accomodation',
        'group_size',
        'group_type',
        'destination_id',
    ];
    protected $casts = [
        'images' => 'array'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function seo(){
        return $this->hasOne(Seo::class);
    }

}
