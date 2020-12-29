<?php

namespace App\Imports;

use App\Constants\CouponConstant;
use App\Constants\CouponMasterConstant;
use App\Repositories\CouponMasterRepository;
use App\Repositories\CouponRepository;
use App\Services\Import;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CouponImport extends Import
{
    protected $couponMasterRepository;
    protected $couponRepository;
    protected $validator;

    /**
     * CouponImport constructor.
     *
     * @param CouponMasterRepository $couponMasterRepository
     * @param CouponRepository $couponRepository
     */
    public function __construct(CouponMasterRepository $couponMasterRepository, CouponRepository $couponRepository)
    {
        $this->couponMasterRepository = $couponMasterRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            CouponConstant::INPUT_CODE => 'required|max:255',
            CouponMasterConstant::INPUT_MEASURE_CODE => 'required|max:50',
            CouponMasterConstant::INPUT_SYS_PERIOD_FROM => 'required',
            CouponMasterConstant::INPUT_SYS_PERIOD_TO => 'required'
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!empty($validator->getData())) {
                $data = array_values($validator->getData())[0];
                $row = array_keys($validator->getData())[0];

                $validator = $this->checkSysPeriodValidation($validator, $data, $row);
            }

            return $validator;
        });
    }

    /**
     * Check sys period validation.
     *
     * @param $validator
     * @param $data
     * @param $row
     *
     * @return mixed
     */
    protected function checkSysPeriodValidation($validator, $data, $row)
    {
        $sysPeriodFrom = Carbon::parse($data[CouponMasterConstant::INPUT_SYS_PERIOD_FROM])->format(DATE_TIME_FORMAT_HIS);
        $sysPeriodTo = Carbon::parse($data[CouponMasterConstant::INPUT_SYS_PERIOD_TO])->format(DATE_TIME_FORMAT_HIS);

        return $this->checkDateRange(
            $validator,
            $row,
            $sysPeriodFrom,
            $sysPeriodTo,
            CouponMasterConstant::INPUT_SYS_PERIOD_TO,
            CouponMasterConstant::HEADER_SYS_PERIOD_TO,
            CouponMasterConstant::HEADER_SYS_PERIOD_FROM
        );
    }

    /**
     * Check date range validation.
     *
     * @param $validator
     * @param $row
     * @param $dateBefore
     * @param $dateAfter
     * @param $column
     * @param $header
     * @param $otherHeader
     *
     * @return mixed
     */
    protected function checkDateRange($validator, $row, $dateBefore, $dateAfter, $column, $header, $otherHeader)
    {
        if ($dateBefore > $dateAfter) {
            $validator->errors()->add(
                $row . '.' . $column,
                __('validation.after', [
                    KEY_ATTRIBUTE => $header,
                    KEY_DATE => $otherHeader
                ])
            );
        }

        return $validator;
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return CouponMasterConstant::HEADER_CSV;
    }

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     *
     * @throws \Throwable
     */
    public function model(array $row)
    {
        $inputCouponMaster = [
            CouponMasterConstant::INPUT_MEASURE_CODE => $row[CouponMasterConstant::INPUT_MEASURE_CODE],
            CouponMasterConstant::INPUT_SYS_PERIOD_FROM => $row[CouponMasterConstant::INPUT_SYS_PERIOD_FROM],
            CouponMasterConstant::INPUT_SYS_PERIOD_TO => $row[CouponMasterConstant::INPUT_SYS_PERIOD_TO],
        ];
        $couponMaster = $this->couponMasterRepository->create($inputCouponMaster);
        throw_if(!$couponMaster, new \Exception(__('message.error.500')));

        $inputCoupon = [
            CouponConstant::INPUT_COUPON_MASTERS_ID => $couponMaster->id,
            CouponConstant::INPUT_CODE => $row[CouponConstant::INPUT_CODE]
        ];
        $coupon = $this->couponRepository->create($inputCoupon);
        throw_if(!$coupon, new \Exception(__('message.error.500')));
    }
}
