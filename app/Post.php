<?php

namespace App;

use Carbon\Carbon;
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

    public function markdown()
    {
        return (new ParsedownExtra)->text($this->body);
    }

    public function save(array $options = [])
    {
        $this->slug = str_slug($this->title);

        return parent::save($options);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
