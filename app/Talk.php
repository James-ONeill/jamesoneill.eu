<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $guarded = [];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', $this->freshTimestamp());
    }
}
