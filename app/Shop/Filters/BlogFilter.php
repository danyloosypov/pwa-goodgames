<?php

namespace App\Shop\Filters;

use App\Models\Blog\Blog;
use App\Models\Blog\Topic;

class BlogFilter extends AbstractFilter
{
    protected $filters = [
        'topic'     => Topic::class,
    ];

    protected $model = Blog::class;
}