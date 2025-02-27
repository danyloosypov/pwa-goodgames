<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'image' => $this->image,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'article_tag' => new ArticleTagResource($this->whenLoaded('articleTag')),
            'article_category' => $this->whenLoaded('articleCategory', function () {
                return $this->articleCategory->title;
            }),
            'reviews_count' => $this->reviews_count,
        ];
    }
}
