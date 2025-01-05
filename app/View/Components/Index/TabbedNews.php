<?php

namespace App\View\Components\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\ArticleCategory;
use App\Models\Article;

class TabbedNews extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = ArticleCategory::all();

        foreach ($this->categories as $category)
        {
            $category->articles = Article::where('id_article_categories', $category->id)->withCategoryAndTag()->latest()->limit(3)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.tabbed-news');
    }
}
