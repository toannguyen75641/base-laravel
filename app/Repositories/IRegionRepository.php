<?php

namespace App\Repositories;

interface IRegionRepository
{
    /**
     * Get list of regions.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL);
}
