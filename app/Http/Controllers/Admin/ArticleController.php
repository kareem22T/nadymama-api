<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'thumbnail' => 'required|string',
            'title' => 'required|string|max:255',
            'brief' => 'required|string',
            'content' => 'required|string',
        ]);

        $article = Article::create($validatedData);
        return response()->json($article, 201);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validatedData = $request->validate([
            'thumbnail' => 'sometimes|required|string',
            'title' => 'sometimes|required|string|max:255',
            'brief' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
        ]);

        $article->update($validatedData);
        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(null, 204);
    }
}
