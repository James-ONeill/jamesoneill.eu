<?php

namespace App;

use ParsedownExtra;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $dates = ['published_at'];

    public function url()
    {
        return $this->published_at->format('/Y/m/d/') . str_slug($this->title);
    }

    public function getDescriptionAttribute()
    {
        return strip_tags(explode(PHP_EOL, $this->body_html)[0]);
    }

    public function getBodyHtmlAttribute()
    {
        return (new ParsedownExtra)->text($this->body);
    }

    public function getPublicationDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y-m-d') : null;
    }

    public function getPublicationTimeAttribute()
    {
        return $this->published_at ? $this->published_at->format('H:i') : null;
    }

    public function getPublishedAttribute()
    {
        return $this->published_at && $this->published_at->subMinute()->isPast();
    }

    public function getPublicationStatusAttribute()
    {
        if ($this->published_at) {
            return 'Published ' . $this->published_at->diffForHumans();
        } else {
            return 'Unpublished';
        }
    }

    public function setThumbnailUrlAttribute($value)
    {
        $this->attributes['thumbnail_url'] = url(str_replace('public/', '', $value));
    }

    public function save(array $options = [])
    {
        $this->slug = str_slug($this->title);

        return parent::save($options);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', $this->freshTimestamp());
    }

    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at')
                     ->orWhere('published_at', '>', $this->freshTimestamp());
    }

    public function scopeScheduled($query)
    {
        return $query->where('published_at', '>', $this->freshTimestamp());
    }

    public function scopeUnscheduled($query)
    {
        return $query->whereNull('published_at');
    }
}
