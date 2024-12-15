<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$categoryId = $request->input('category_id');

        // Build the query for articles
        $articlesQuery = Article::query();

        // If a category filter is provided, apply it
        if ($categoryId) {
            $articlesQuery->where('id_article_categories', $categoryId);
        }

        // Paginate the articles (13 per page)
        $articles = $articlesQuery->withCategoryAndTag()->paginate(13);

        // Get all article categories to display in the filter
        $categories = ArticleCategory::all();

        $latestArticles = Article::withCategoryAndTag()->latest()->limit(3)->get();

        // Get 3 random articles for the "most popular" section
        $mostPopularArticles = Article::withCategoryAndTag()->inRandomOrder()->limit(3)->get();

        // Get 3 random products for the "most popular" section (assuming you have a Product model)
        $mostPopularProducts = Product::inRandomOrder()->limit(3)->get();

        // Return the view with paginated articles, available categories, and popular items
        return view('pages.blog.blog', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'latestArticles' => $latestArticles,
            'mostPopularArticles' => $mostPopularArticles,
            'mostPopularProducts' => $mostPopularProducts,
        ]); 
	}

    public function show()
	{
		return view('pages.blog.article', [

		]); 
	}
}