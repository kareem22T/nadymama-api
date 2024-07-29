<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Services\ArticleService;
use App\Traits\ApiResponser;

class ArticleController extends Controller
{
    use ApiResponser;

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->getAllArticles();
        return $this->successResponse($articles);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleService->createArticle($request->validated());
        return $this->successResponse($article, 'Article created successfully', 201);
    }

    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        return $this->successResponse($article);
    }

    public function update(StoreArticleRequest $request, $id)
    {
        $article = $this->articleService->updateArticle($id, $request->validated());
        return $this->successResponse($article, 'Article updated successfully');
    }

    public function destroy($id)
    {
        $this->articleService->deleteArticle($id);
        return $this->successResponse(null, 'Article deleted successfully', 204);
    }
}
