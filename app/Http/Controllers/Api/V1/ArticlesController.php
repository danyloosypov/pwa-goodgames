<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::withCategoryAndTag()->get();
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:articles,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'id_article_categories' => 'required|exists:categories,id',
            'id_article_tags' => 'array|exists:tags,id', // Optional tags
            'date' => 'nullable|date',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new article
        $article = Article::create($request->all());

        // Attach tags (if provided)
        if ($request->has('id_article_tags')) {
            $article->articleTag()->sync($request->id_article_tags);
        }

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::withCategoryAndTag()->findOrFail($id);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the article or fail
        $article = Article::findOrFail($id);

        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:articles,slug,' . $article->id,
            'content' => 'sometimes|required|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'id_article_categories' => 'sometimes|required|exists:categories,id',
            'id_article_tags' => 'array|exists:tags,id', // Optional tags
            'date' => 'nullable|date',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update article data
        $article->update($request->all());

        // Sync tags (if provided)
        if ($request->has('id_article_tags')) {
            $article->tags()->sync($request->id_article_tags);
        }

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the article or fail
        $article = Article::findOrFail($id);

        // Delete the article
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully.']);
    }
}
