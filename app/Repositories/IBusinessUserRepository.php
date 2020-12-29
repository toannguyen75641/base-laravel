<?php

namespace App\Repositories;

interface IBusinessUserRepository
{
    /**
     * Get all of business users.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getAll(array $columns = SELECT_ALL);

    /**
     * Get list of business users.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = []);

    /**
     * Get business user detail.
     *
     * @param $id
     * @param array $columns
     * @param $deletedAt
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL, $deletedAt = false);

    /**
     * Delete business user.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}
