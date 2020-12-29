<?php

namespace App\Repositories;

interface ICouponManagementRepository
{
    /**
     * Get list of couponManagement.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = []);

    /**
     * Get coupon management detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL);
}
