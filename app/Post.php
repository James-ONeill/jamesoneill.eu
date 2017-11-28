<?php

namespace App;

use Storage;
use ParsedownExtra;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use App\Events\PostPublished;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Feedable
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
        return $this->published_at
            ? $this->published_at->format('Y-m-d') : null;
    }

    public function getPublicationTimeAttribute()
    {
        return $this->published_at ? $this->published_at->format('H:i') : null;
    }

    public function getIsPublishedAttribute()
    {
        return $this->published_at && $this->published_at->subMinute()->isPast();
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getPublicationStatusAttribute()
    {
        if ($this->published_at) {
            return 'Published ' . $this->published_at->diffForHumans();
        } else {
            return 'Unpublished';
        }
    }

    public function getThumbnailAttribute()
    {
        return url(Storage::url($this->attributes['thumbnail_url']));
    }

    public function publish()
    {
        return tap($this->update([
            'published_at' => $this->freshTimestamp()
        ]), function () {
            event(new PostPublished($this));
        });
    }

    public function unpublish()
    {
        return $this->update(['published_at' => null]);
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

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->updated_at)
            ->link($this->url())
            ->author("James O'Neill");
    }

    public static function getFeedItems()
    {
        return static::published()->get();
    }
}
