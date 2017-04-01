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

    public function index()
    {
        return collect($this->files->directories(base_path('resources/posts')))->mapWithKeys(function ($dir) {
            return [
                substr($dir, -4) => collect($this->files->directories($dir))->mapWithKeys(function ($dir) {
                    return [
                        substr($dir, -2) => collect($this->files->directories($dir))->mapWithKeys(function ($dir) {
                            return [
                                substr($dir, -2) => collect($this->files->files($dir))->map(function ($file) {
                                    return $this->markdown->text($this->files->get($file));
                            })];
                })];
            })];
        })->filter();
    }

    public function get($year, $month, $day, $title)
    {
        $path = base_path("resources/posts/{$year}/{$month}/{$day}/{$title}.md");

        if ($this->files->exists($path)) {
            return $this->markdown->text($this->files->get($path));
        }

        return null;
    }

    protected function getYears()
    {
        return collect($this->files->directories(base_path('resources/posts')))->mapWithKeys(function ($dir) {
            return [ substr($dir, -4) => $this->getMonths($dir)];
        })->filter;
    }

    protected function getMonths()
    {}
}