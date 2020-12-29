<?php

namespace App\Repositories;

use App\Constants\CouponMasterConstant;
use App\Models\CouponMaster;
use App\Repositories\Base\BaseRepository;

class CouponMasterRepository extends BaseRepository implements ICouponMasterRepository
{
    /**
     * Get CouponMaster model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return CouponMaster::class;
    }

    /**
     * Get list of coupon_master.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [])
    {
        $query = CouponMaster::query()
            ->select($columns)
            ->with('coupons');

        if (isset($condition[CouponMasterConstant::INPUT_MEASURE_CODE])) {
            $query->where(CouponMasterConstant::INPUT_MEASURE_CODE, OPERATOR_LIKE, '%'.$condition[CouponMasterConstant::INPUT_MEASURE_CODE].'%');
        }
        if (isset($condition[CouponMasterConstant::INPUT_FLG])) {
            $query->where(CouponMasterConstant::INPUT_FLG, $condition[CouponMasterConstant::INPUT_FLG]);
        }
        if (isset($condition[CouponMasterConstant::INPUT_SYS_PERIOD_FROM])) {
            $query->where(CouponMasterConstant::INPUT_SYS_PERIOD_FROM, '>=', $condition[CouponMasterConstant::INPUT_SYS_PERIOD_FROM]);
        }
        if (isset($condition[CouponMasterConstant::INPUT_SYS_PERIOD_TO])) {
            $query->where(CouponMasterConstant::INPUT_SYS_PERIOD_TO, '<=', $condition[CouponMasterConstant::INPUT_SYS_PERIOD_TO]);
        }

        return $query->paginate(PAGE_SIZE_20, $columns);
    }

    /**
     * Get coupon master detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL)
    {
        return parent::getDetail($id, $columns)->first();
    }
}
