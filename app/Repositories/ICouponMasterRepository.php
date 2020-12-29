<?php

namespace App\Repositories;

interface ICouponMasterRepository
{
    /**
     * Get list of coupon_master.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = []);

    /**
     * Get list of coupon master.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL);
}
