<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $guarded = [];

    protected $dates = ['published_at'];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', $this->freshTimestamp());
    }

    public function getIsPublishedAttribute()
    {
        return $this->published_at && $this->published_at->subMinute()->isPast();
    }

    public function publish()
    {
        return $this->update(['published_at' => $this->freshTimestamp()]);
    }

    public function unpublish()
    {
        return $this->update(['published_at' => null]);
    }
}
