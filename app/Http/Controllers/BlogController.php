<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleCategory;

class BlogController extends Controller
{
	public function index(Request $request)
	{
        return view('pages.blog.blog'); 
	}

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->withCategoryAndTag() 
            ->with('reviews')
            ->firstOrFail();

        $similarArticles = Article::where('id_article_categories', $article->id_article_categories)
        ->where('id', '!=', $article->id) 
        ->withCategoryAndTag() 
        ->limit(2)
        ->get();

        return view('pages.blog.article', [
            'article' => $article,
            'similarArticles' => $similarArticles,
        ]);
    }
}