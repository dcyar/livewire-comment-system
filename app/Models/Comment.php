<?php

namespace App\Models;

use App\Models\Presenters\CommentPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function scopeParent(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function presenter()
    {
        return new CommentPresenter($this);
    }

    public function isParent()
    {
        return is_null($this->parent_id);
    }
}
