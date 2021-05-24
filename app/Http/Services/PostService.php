<?php

namespace App\Http\Services;

use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;

class PostService
{
    private $postRepository;
    private $commentRepository;

    public function __construct(PostRepository $postRepository, CommentRepository $commentRepository)
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    public function store(array $request, int $user_id)
    {
        DB::beginTransaction();
        try {
            $request['user_id'] = $user_id;
            $this->postRepository->store($request);
            DB::commit();
            return [
                'message' => 'Post saved successfully'
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new $ex;
        }
    }

    public function update(array $request, int $id)
    {
        DB::beginTransaction();
        try {
            $this->postRepository->update($request, $id);
            DB::commit();
            return [
                'message' => 'Post updated successfully'
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new $ex;
        }
    }

    public function delete(object $post)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->deleteByPostId($post->id);
            $this->postRepository->deleteById($post->id);
            DB::commit();
            return [
                'message' => 'Post deleted successfully'
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new $ex;
        }
    }
}
