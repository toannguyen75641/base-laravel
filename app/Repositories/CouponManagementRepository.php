<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\CouponManagement;
use App\Repositories\Base\BaseRepository;

class CouponManagementRepository extends BaseRepository implements ICouponManagementRepository
{
    /**
     * Get CouponManagement model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return CouponManagement::class;
    }

    /**
     * Get list of couponManagement.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [])
    {
        $query = CouponManagement::query()->get();

        return $query;
    }

    /**
     * Get coupon management detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL)
    {
        $query = parent::getDetail($id, $columns);

        return $query->first();
    }
}
