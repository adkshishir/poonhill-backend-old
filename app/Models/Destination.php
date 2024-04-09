<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_activity_id',
    ];
    public function parentActivity()
    {
        return $this->belongsTo(ParentActivity::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
