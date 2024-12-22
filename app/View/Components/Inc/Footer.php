<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;
use App\Models\Article;

class Footer extends Component
{
    public $articles;

    public function __construct()
	{
        $this->articles = Article::withCategoryAndTag()->latest()->limit(2)->get();
    }

    public function render()
	{
        return view('components.inc.footer');
    }
}
