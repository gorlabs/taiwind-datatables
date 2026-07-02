<?php

namespace App\Livewire;

use App\Models\Post;
use App\Livewire\Forms\PostForm;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.posts-demo')]
class PostsTable extends Component
{
    use WithPagination;

    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $search = '';

    public PostForm $form;
    public bool $showModal = false;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createPost()
    {
        $this->form->reset();
        $this->showModal = true;
    }

    public function editPost(Post $post)
    {
        $this->form->setPost($post);
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->form->post) {
            $this->form->update();
        } else {
            $this->form->store();
        }
        $this->showModal = false;
    }

    public function deletePost(Post $post)
    {
        $post->delete();
    }

    public function render()
    {
        $posts = Post::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.posts-table', [
            'posts' => $posts,
        ]);
    }
}
