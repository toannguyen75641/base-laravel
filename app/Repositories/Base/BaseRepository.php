<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements IBaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model.
     *
     * @return mixed
     */
    protected abstract function getModel();

    /**
     * Set model.
     */
    private function setModel() : void
    {
        $this->model = app($this->getModel());
    }

    /**
     * Get the model detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return Builder
     */
    public function getDetail($id, array $columns = SELECT_ALL)
    {
        return $this->model
            ->newQuery()
            ->select($columns)
            ->where(FIELD_ID, OPERATOR_EQUAL, $id);
    }

    /**
     * Get the model detail by condition.
     *
     * @param $condition
     * @param array $columns
     *
     * @return Builder
     */
    public function getByCondition($condition, array $columns = SELECT_ALL)
    {
        return $this->model
            ->newQuery()
            ->select($columns)
            ->where($condition);
    }

    /**
     * Create new model.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function create(array $input)
    {
        try {
            $newModel = new $this->model($input);
            $newModel->save();
        } catch (\Exception $exception) {
            Log::error('[Create]: ' . $exception->getMessage());
            $newModel = null;
        }

        return $newModel;
    }

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $input
     *
     * @return mixed
     */
    public function update(Model $model, array $input)
    {
        try {
            foreach ($input as $attribute => $value) {
                $model->{$attribute} = $value;
            }
            if ($model->isDirty()) {
                $model->save();
            }
        } catch (\Exception $exception) {
            Log::error('[Update]: ' . $exception->getMessage());
            $model = null;
        }

        return $model;
    }   
}
