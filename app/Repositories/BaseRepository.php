<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * The repository model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Get all the model records in the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->getModel()->get()->all();
    }

    protected function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Count the number of specified model records in the database
     *
     * @return int
     */
    public function count()
    {
        return $this->getModel()->get()->count();
    }

    /**
     * Create one or more new model records in the database
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createMultiple(array $data)
    {
        $models = new Collection();
        foreach ($data as $d) {
            $models->push($this->create($d));
        }
        return $models;
    }

    /**
     * Create a new model record in the database
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    /**
     * Delete the specified model record from the database
     *
     * @param $id
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteById($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Get the specified model record from the database
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Get the first specified model record from the database
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function first()
    {
        return $this->getModel()->firstOrFail();
    }

    /**
     * Get all the specified model records in the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($criteria = null, $order = null)
    {
        $model = $this->getModel();
        if (!emptyArray($criteria)) {
            foreach ($criteria as $field => $value) {
                $model->where($field, $value);
            }
        }
        return $model->get();
    }

    /**
     * Update the specified model record in the database
     *
     * @param       $id
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateById($id, array $data)
    {
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }
}
