<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wallpaper extends Model
{
    protected $fillable = ['name','price','category_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
