<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository {
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function filter($filters)
    {
        $search = explode(':', $filters);
        $this->model = $this->model->where($search[0], $search[1], $search[2]);
        // foreach ($filters as $filter) {
        //     [$field, $operator, $value] = explode(':', $filter);
        //     $this->model = $this->model->orWhere($field, $operator, $value);
        // }
    }

    public function filterOrder($filters)
    {
        $search = explode(':', $filters);
        $this->model = $this->model->with(['client', 'product'])->where($search[0], $search[1], $search[2]);

    }

    public function getResult()
    {
        return $this->model->get();
    }

    public function getResultPaginate($numberByPages)
    {
        return $this->model->paginate();
    }
}
