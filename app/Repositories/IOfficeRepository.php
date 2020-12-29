<?php

namespace App\Repositories;

interface IOfficeRepository
{
    /**
     * Get list of offices.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL);

    /**
     * Get office detail.
     *
     * @param $id
     * @param array $columns
     * @param $deletedAt
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL, $deletedAt = false);
}
