<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $articles = Article::all();
        return $this->successResponse($articles);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'thumbnail' => 'required|file|image|max:2048', // Ensure it's an image file and limit size
            'title' => 'required|string|max:255',
            'brief' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $this->storePhoto($request->file('thumbnail'));
        }

        $article = Article::create($validatedData);
        return $this->successResponse($article);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return $this->successResponse($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validatedData = $request->validate([
            'thumbnail' => 'sometimes|file|image|max:2048', // Ensure it's an image file and limit size
            'title' => 'sometimes|required|string|max:255',
            'brief' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validatedData['thumbnail'] = $this->storePhoto($request->file('thumbnail'));
        }

        $article->update($validatedData);
        return $this->successResponse($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Delete the associated thumbnail
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();
        return response()->json(null, 204);
    }

    protected function storePhoto($photo)
    {
        $path = $photo->store('photos', 'public'); // stores the photo in the 'storage/app/public/photos' directory
        return $path;
    }
}
