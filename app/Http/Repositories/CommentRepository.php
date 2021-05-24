<?php

namespace App\Http\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function store(array $request)
    {
        return Comment::create($request);
    }

    public function deleteByPostId(int $id)
    {
        return Comment::wherePostId($id)->delete();
    }
}
