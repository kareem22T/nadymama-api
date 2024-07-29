<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Exception;

class ArticleRepository implements ArticleRepositoryInterface
{
    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $article = $this->model->create($data);
            DB::commit();
            return $article;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $article = $this->model->findOrFail($id);
            $article->update($data);
            DB::commit();
            return $article;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $article = $this->model->findOrFail($id);
            $article->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
