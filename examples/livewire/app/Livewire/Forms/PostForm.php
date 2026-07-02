<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $post = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $content = '';

    #[Validate('boolean')]
    public bool $is_published = false;

    #[Validate('nullable|date')]
    public ?string $published_at = null;

    public function setPost(Post $post): void
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->is_published = $post->is_published;
        $this->published_at = $post->published_at?->format('Y-m-d\TH:i');
    }

    public function store(): void
    {
        $this->validate();
        Post::create($this->only(['title', 'content', 'is_published', 'published_at']));
        $this->reset();
    }

    public function update(): void
    {
        $this->validate();
        $this->post->update($this->only(['title', 'content', 'is_published', 'published_at']));
        $this->reset();
    }
}
