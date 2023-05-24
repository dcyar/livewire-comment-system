<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $model;

    public $newCommentState = [
        'body' => '',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment',
    ];

    public function postComment()
    {
        $this->validate([
            'newCommentState.body' => 'required',
        ]);

        $comment = $this->model->comments()->make($this->newCommentState);
        $comment->user()->associate(auth()->user());

        $comment->save();

        $this->reset('newCommentState');
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->model
                ->comments()
                ->with('user', 'children.user', 'children.children')
                ->parent()
                ->latest()
                ->paginate(3),
        ]);
    }
}
