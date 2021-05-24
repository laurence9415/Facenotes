<?php

namespace App\Http\Repositories;

use App\Models\Post;

class PostRepository
{
    public function store(array $request)
    {
        return Post::create($request);
    }

    public function update(array $request, int $id)
    {
        return Post::findOrFail($id)->update($request);
    }

    public function deleteById(int $id)
    {
        return Post::findOrFail($id)->delete();
    }
}
