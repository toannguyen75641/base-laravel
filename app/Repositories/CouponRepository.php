<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Base\BaseRepository;

class CouponRepository extends BaseRepository implements ICouponRepository
{
    /**
     * Get Coupon model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Coupon::class;
    }
}
