<?php

namespace App\Repositories;

interface IDepartmentRepository
{
    /**
     * Get list of departments.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = []);

    /**
     * Delete department.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}
