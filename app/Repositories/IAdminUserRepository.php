<?php

namespace App\Repositories;

interface IAdminUserRepository
{
    /**
     * Get list of admin users.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = []);

    /**
     * Delete admin user.
     *
     * @param $id
     * @param $auth
     *
     * @return mixed
     */
    public function delete($id, $auth);
}
