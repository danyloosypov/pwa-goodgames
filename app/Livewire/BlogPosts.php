<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\ArticleCategory;

class BlogPosts extends Component
{
    use WithPagination;

    public $categoryId = 0;
    public $page = 1;

    protected $queryString = [
        'categoryId' => ['except' => 0],
        'page' => ['except' => 1],
    ];

    public function render()
    {
        $posts = Article::when($this->categoryId, function($query) {
            $query->where('id_article_categories', $this->categoryId);
        })
        ->withCategoryAndTag()
        ->paginate(13);

        $categories = ArticleCategory::all();

        return view('livewire.blog-posts', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function paginationView()
    {
        return 'custom-pagination-links-view';
    }

    public function setCategory($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->resetPage(); 
    }
}
