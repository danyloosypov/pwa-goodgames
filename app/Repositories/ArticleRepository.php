<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles with optional filtering and pagination.
     */
    public function getAll(Request $request): LengthAwarePaginator
    {
        $title = $request->query('title');
        $category = $request->query('category');
        $date = $request->query('date');

        $query = Article::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($category) {
            $query->whereHas('articleCategory', function ($q) use ($category) {
                $q->where('title', 'like', '%' . $category . '%');
            });
        }

        if ($date) {
            $query->whereDate('date', $date);
        }


        // Paginate with 10 per page
        return $query->paginate(10);
    }

    /**
     * Find an article by ID.
     */
    public function findById(int $id)
    {
        return Article::findOrFail($id);
    }

    /**
     * Create a new article.
     */
    public function create(array $data)
    {
        return Article::create($data);
    }

    /**
     * Update an article by ID.
     */
    public function update(int $id, array $data)
    {
        $article = Article::findOrFail($id);
        $article->update($data);

        return $article;
    }

    /**
     * Delete an article by ID.
     */
    public function delete(int $id)
    {
        $article = Article::findOrFail($id);
        return $article->delete();
    }
}
