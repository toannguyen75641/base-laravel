<?php

namespace App\Repositories;

use App\Models\Region;
use App\Repositories\Base\BaseRepository;

class RegionRepository extends BaseRepository implements IRegionRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Region::class;
    }

    /**
     * Get list of regions.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL)
    {
        return Region::query()
            ->select($columns)
            ->with('office')
            ->get();
    }
}