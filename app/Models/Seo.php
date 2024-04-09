<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    protected $fillable =[
        "meta_title",
        "meta_description",
        "meta_keywords",
        "canonical",
        "activity_id",
        "schema"
    ];
    function activity(){
        return $this->belongsTo(Activity::class);
    }
}
