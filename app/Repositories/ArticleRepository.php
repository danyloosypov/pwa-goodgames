<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::denies('create-article')) {
            abort(403, 'Unauthorized');
        }

        // Create a new article for 'uk' locale
        $articleUk = new Article('uk');
        $articleUk->title = $data['title'];
        $articleUk->slug = $data['slug'];
        $articleUk->date = $data['date'];
        $articleUk->excerpt = $data['excerpt'] ?? '';
        $articleUk->image = $data['image'] ?? '';
        $articleUk->id_article_tags = $data['id_article_tags'];
        $articleUk->id_article_categories = $data['id_article_categories'];
        $articleUk->content = $data['content'];
        $articleUk->is_show = $data['is_show'];
        $articleUk->meta_title = $data['meta_title'] ?? '';
        $articleUk->meta_description = $data['meta_description'] ?? '';
        $articleUk->meta_keywords = $data['meta_keywords'] ?? '';
        $articleUk->save();
        
        // Create a new article for 'en' locale
        $articleEn = new Article('en');
        $articleEn->title = $data['title'];
        $articleEn->slug = $data['slug'];
        $articleEn->date = $data['date'];
        $articleEn->excerpt = $data['excerpt'] ?? '';
        $articleEn->image = $data['image'] ?? '';
        $articleEn->id_article_tags = $data['id_article_tags'];
        $articleEn->id_article_categories = $data['id_article_categories'];
        $articleEn->content = $data['content'];
        $articleEn->is_show = $data['is_show'];
        $articleEn->meta_title = $data['meta_title'] ?? '';
        $articleEn->meta_description = $data['meta_description'] ?? '';
        $articleEn->meta_keywords = $data['meta_keywords'] ?? '';
        $articleEn->save();
        
        return $articleUk;
    }

    /**
     * Update an article by ID.
     */
    public function update(int $id, array $data)
    {
        if (Gate::denies('update-article')) {
            abort(403, 'Unauthorized');
        }

        $article = Article::findOrFail($id);
        $article->update($data);

        return $article;
    }

    /**
     * Delete an article by ID.
     */
    public function delete(int $id)
    {
        if (Gate::denies('delete-article')) {
            abort(403, 'Unauthorized');
        }

        $article = Article::findOrFail($id);
        return $article->delete();
    }
}
