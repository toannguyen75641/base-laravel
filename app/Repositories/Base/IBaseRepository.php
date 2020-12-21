<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    /**
     * Get the model detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL);
    
    /**
     * Get the model detail by condition.
     *
     * @param $condition
     * @param array $columns
     *
     * @return Builder
     */
    public function getByCondition($condition, array $columns = SELECT_ALL);

    /**
     * Create new model.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function create(array $input);

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $input
     *
     * @return mixed
     */
    public function update(Model $model, array $input);
}
