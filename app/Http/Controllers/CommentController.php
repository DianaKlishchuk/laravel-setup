<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        $comments = $task->comments()
            ->latest()
            ->paginate(10);

        return CommentResource::collection($comments);
    }

    public function store(
        StoreCommentRequest $request,
        Task $task
    ) {
        $comment = $task->comments()->create(
            $request->validated()
        );

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(
        UpdateCommentRequest $request,
        Comment $comment
    ) {
        $comment->update($request->validated());

        return new CommentResource($comment->refresh());
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
