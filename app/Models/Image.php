<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
