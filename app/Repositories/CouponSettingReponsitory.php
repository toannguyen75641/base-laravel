<?php

namespace App\Repositories;

use App\Models\CouponSetting;
use App\Repositories\Base\BaseRepository;

class CouponSettingReponsitory extends BaseRepository implements ICouponSettingReponsitory
{
    /**
     * Get Coupon model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return CouponSetting::class;
    }

    public function getCoupon($input) {
        
        $coupon = CouponSetting::first();
        if (isset($coupon)) {
            $result = $this->update($coupon, $input);
        } else {
            $result = $this->create($input);
        }
        return $result;
    }
}
