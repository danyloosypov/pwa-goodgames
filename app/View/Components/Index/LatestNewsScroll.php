<?php

namespace App\View\Components\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Article;

class LatestNewsScroll extends Component
{
    public $articles;
    public $articlesRow;

    public function __construct()
    {
        $this->articles = Article::withCategoryAndTag()->latest()->limit(8)->get();

        $this->articlesRow = Article::withCategoryAndTag()
        ->latest()
        ->get()
        ->groupBy('id_article_categories') 
        ->map(function ($group) {
            return $group->first(); 
        })
        ->take(4);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.latest-news-scroll');
    }
}
