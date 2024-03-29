<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

public function store(Request $request, Product $product)
{
    $request->validate([
        'content' => 'required|min:3',
    ]);

    try {
        //! Retrieve the authenticated user
        $user = auth()->user();

        //! Create a new comment
        $comment = new Comment([
            'content' => $request->input('content'),
        ]);

        //! Associate the user with the comment
        $comment->user()->associate($user);

        //! Save the comment to the product
        $product->comments()->save($comment);

        //! Return the created comment
        return response()->json(['data' => $comment], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
