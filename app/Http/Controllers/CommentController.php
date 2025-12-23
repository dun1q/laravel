<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Car $car)
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $car->comments()->create([
            'user_id' => auth()->id(),
            'text'    => $request->text,
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        // здесь можно добавить проверку прав (только автор или админ)
        $comment->delete();
        return back();
    }
}