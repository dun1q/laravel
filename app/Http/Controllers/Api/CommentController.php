<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::with(['car', 'user'])->get());
    }

    public function show(Comment $comment)
    {
        $comment->load(['car', 'user']);
        return new CommentResource($comment);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'text' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = $request->user()->id;
        $comment = Comment::create($validated);

        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:1000',
        ]);
        $comment->update($validated);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Комментарий удалён']);
    }

}
