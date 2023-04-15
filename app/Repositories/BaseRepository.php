<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 *
 */
abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Model
     */
    private $queryBuilder;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->setModel($model);
        $this->setQueryBuilder($this->getModel());
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     * @return $this
     */
    protected function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param       $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $model = $this->getModel()->find($id);
        if ($model) {
            return $model->update($data);
        }


    }

    /**
     * @param array $parameters
     * @return Model
     */
    public function create(array $parameters)
    {
        return $this->getModel()->create($parameters)->fresh();
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->getModel()->destroy($id);
    }

    /**
     * @param       $id
     * @param       $relation
     * @param array $values
     */
    public function syncWithRelation($id, $relation, array $values)
    {
        $model = $this->find($id);

        if (empty($model)) {
            throw new ModelNotFoundException("Model Empty");
        }

        return $model->$relation()->syncWithoutDetaching($values);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * @return collection
     */
    public function all()
    {
        return $this->getModel()->all();
    }

    /**
     * @return Model
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function setQueryBuilder($queryBuilder)
    {
        return $this->queryBuilder = $queryBuilder;
    }

    /**
     * Return specified number of resources
     *
     * @param integer $take
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($take)
    {
        return $this->getModel()->orderBy('created_at', 'desc')->paginate($take);
    }
    
}