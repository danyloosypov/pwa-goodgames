<?php

namespace App\DTO;

readonly final class ArticleDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $slug,
        public string $date,
        public string $excerpt,
        public string $image,
        public int $id_article_tags,
        public int $id_article_categories,
        public string $content,
        public int $is_show,
        public string $meta_title,
        public string $meta_description,
        public string $meta_keywords,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'image' => $this->image,
            'id_article_tags' => $this->id_article_tags,
            'id_article_categories' => $this->id_article_categories,
            'content' => $this->content,
            'is_show' => $this->is_show,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
        ];
    }
}
