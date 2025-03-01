<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->middleware('auth:sanctum',   ['only' => ['store', 'update', 'delete']]);
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
    public function store(ArticleRequest $request)
    {
        // Create a new article
        $article = $this->articleRepository->create($request->getDTO()->toArray());

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
    public function update(ArticleRequest $request, int $id)
    {
        // Update the article
        $article = $this->articleRepository->update($id, $request->getDTO()->toArray());

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
