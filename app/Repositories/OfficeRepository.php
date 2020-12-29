<?php

namespace App\Repositories;

use App\Constants\OfficeConstant;
use App\Models\Office;
use App\Repositories\Base\BaseRepository;

class OfficeRepository extends BaseRepository implements IOfficeRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Office::class;
    }

    /**
     * Get list of offices.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL)
    {
        return Office::query()
            ->select($columns)
            ->whereNull(OfficeConstant::INPUT_DELETE_AT)
            ->get();
    }

    /**
     * Get office detail.
     *
     * @param $id
     * @param array $columns
     * @param $deletedAt
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL, $deletedAt = false)
    {
        $query = parent::getDetail($id, $columns);
        if(!$deletedAt) {
            $query->whereNull(OfficeConstant::INPUT_DELETE_AT);
        }
        return $query->first();
    }
}
