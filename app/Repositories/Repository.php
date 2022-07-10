<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAttributesRelatedRecords($attributes)
    {
        // Guarda o estado da query que está sendo montada
        $this->model = $this->model->with($attributes);
    }

    public function selectAttributes($attributes)
    {
        $this->model = $this->model->selectRaw($attributes);
    }

    public function filter($filters)
    {
        $filters = explode(';', $filters);

        foreach ($filter as $key => $condition) {
            $c = explode(':', $condition);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
        }
    }

    public function get()
    {
        return $this->model->get();
    }
}
