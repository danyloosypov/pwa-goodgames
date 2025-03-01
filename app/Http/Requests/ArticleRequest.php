<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\ArticleDTO;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'exists:articles_uk,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'excerpt' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'id_article_tags' => ['required', 'integer'],
            'id_article_categories' => ['required', 'integer'],
            'content' => ['required', 'string'],
            'is_show' => ['required', 'integer', 'in:0,1'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function getDTO(): ArticleDTO
    {
        return new ArticleDTO(
            id: $this->input('id', 0),
            title: $this->input('title'),
            slug: $this->input('slug'),
            date: $this->input('date'),
            excerpt: $this->input('excerpt') ?? '',
            image: $this->input('image') ?? '',
            id_article_tags: $this->input('id_article_tags'),
            id_article_categories: $this->input('id_article_categories'),
            content: $this->input('content'),
            is_show: $this->input('is_show'),
            meta_title: $this->input('meta_title') ?? '',
            meta_description: $this->input('meta_description') ?? '',
            meta_keywords: $this->input('meta_keywords') ?? ''
        );
    }
}
