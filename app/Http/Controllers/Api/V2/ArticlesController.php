<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all articles with pagination and filtering
        $articles = $this->articleRepository->getAll($request);

        // Return the paginated collection of articles
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create a new article
        $article = $this->articleRepository->create($request->all());

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find an article by ID
        $article = $this->articleRepository->findById($id);

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Update the article
        $article = $this->articleRepository->update($id, $request->all());

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the article
        $this->articleRepository->delete($id);

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
