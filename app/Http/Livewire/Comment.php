<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Comment extends Component
{
    use AuthorizesRequests;

    public $comment;
    public $isReplying = false;
    public $replyState = [
        'body' => '',
    ];
    public $isEditing = false;
    public $editState = [
        'body' => '',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    protected $validationAttributes = [
        'replyState.body' => 'reply',
    ];

    public function updatedIsEditing(bool $isEditing)
    {
        if (!$isEditing) return;

        $this->editState = [
            'body' => $this->comment->body,
        ];
    }

    public function editComment()
    {
        $this->authorize('update', $this->comment);

        $this->comment->update($this->editState);

        $this->reset('isEditing');
    }

    public function postReply()
    {
        if (!$this->comment->isParent()) {
            return;
        }

        $this->validate([
            'replyState.body' => 'required',
        ]);

        $reply = $this->comment->children()->make($this->replyState);
        $reply->user()->associate(auth()->user());
        $reply->commentable()->associate($this->comment->commentable);
        $reply->save();

        $this->reset(['isReplying', 'replyState']);

        $this->emitSelf('refresh');
    }

    public function deleteComment()
    {
        $this->authorize('destroy', $this->comment);

        $this->comment->delete();

        $this->emitUp('refresh');
    }

    public function render()
    {
        return view('livewire.comment');
    }
}
