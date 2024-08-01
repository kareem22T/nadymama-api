<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::latest()->paginate(20); // You can adjust the number per page as needed
        return response()->json($articles);
    }

    public function article($articleId)
    {
        $article = Article::with("phones")->find($articleId);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

}
