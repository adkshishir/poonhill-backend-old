<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'package_id',
    ];
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function destination()
    {
        return $this->hasMany(Destination::class);
    }
}
