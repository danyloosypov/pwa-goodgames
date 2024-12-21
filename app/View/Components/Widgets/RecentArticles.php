<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Article;

class RecentArticles extends Component
{
    public $articles;

    public function __construct()
    {
        $this->articles = Article::withCategoryAndTag()->latest()->limit(3)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.recent-articles');
    }
}
