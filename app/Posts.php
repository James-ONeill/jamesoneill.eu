<?php

namespace App;

use ParsedownExtra;
use Illuminate\Filesystem\Filesystem;

class Posts
{
    protected $files;

    protected $markdown;

    public function __construct(Filesystem $files, ParsedownExtra $markdown)
    {
        $this->files = $files;
        $this->markdown = $markdown;
    }

    public function get($year, $month, $day, $title)
    {
        $path = base_path("resources/posts/{$year}/{$month}/{$day}/{$title}.md");

        if ($this->files->exists($path)) {
            return $this->markdown->text($this->files->get($path));
        }

        return null;
    }
}