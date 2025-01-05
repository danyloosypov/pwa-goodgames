<?php

namespace App\View\Components\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Article;

class LatestNewsGrid extends Component
{
    public $articles;

    public function __construct()
    {
        $this->articles = Article::withCategoryAndTag()->latest()->limit(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.latest-news-grid');
    }
}
