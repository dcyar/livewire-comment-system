<?php

namespace App\Models\Presenters;

use App\Models\Comment;
use Illuminate\Support\HtmlString;

class CommentPresenter
{
    public function __construct(private Comment $comment)
    {}

    public function markdownBody()
    {
        return new HtmlString(
            app('markdown')->convert($this->comment->body)
        );
    }

    public function relativeCreatedAt()
    {
        return $this->comment->created_at->diffForHumans();
    }
}