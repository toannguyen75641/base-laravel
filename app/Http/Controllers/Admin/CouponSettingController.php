<?php

namespace App\Http\Controllers\admin;

use App\Constants\CouponSettingConstant;
use App\Http\Controllers\Controller;
use App\Repositories\CouponSettingReponsitory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\FileHelper;
use App\Models\CouponSetting;

class CouponSettingController extends Controller
{
    protected $couponSettingRepository;

    /**
     * CouponSettingController constructor.
     *
     * @param CouponSettingReponsitory $couponSettingRepository
     */
    public function __construct
    (
        CouponSettingReponsitory $couponSettingRepository
    )
    {
        $this->couponSettingRepository = $couponSettingRepository;
    }

    /**
     * View coupon setting
     *
     * @return Factory|View
     */
    public function getCouponSetting()
    {
        $coupons = CouponSetting::all();
        return view('page.coupon.setting', compact('coupons'));
    }

    /**
     * View add banner coupon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTableBanner(Request $request)
    {
        $data = $request->only([
            CouponSettingConstant::NUMBER_ITEMS,
        ]);
        $num   = $data[CouponSettingConstant::NUMBER_ITEMS];
        $coupons = CouponSetting::all();
        $table = view('page.coupon.table_banner',compact('num','coupons'))->render();
        if ($data[CouponSettingConstant::NUMBER_ITEMS] < CouponSettingConstant::MAX_BANNER) {
            $response = [
                'status'  => 'success',
                'html'    => $table
            ];
        } else {
            $response = [
                'status' => 'failed',
                'message' => __('message.coupon_setting.error.max_banner'),
            ];
        }
        return response()->json($response);
    }

    /**
     * View add coupon_setting
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCouponSetting(Request $request)
    {
        $input = $request->only([
            CouponSettingConstant::INPUT_FREE_IMG,
            CouponSettingConstant::INPUT_FREE_URL,
            CouponSettingConstant::INPUT_BUTTON_URL,
            CouponSettingConstant::INPUT_BANNER_HEADING_1,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_1,
            CouponSettingConstant::INPUT_BANNER_IMG_1,
            CouponSettingConstant::INPUT_BANNER_URL_1,
            CouponSettingConstant::INPUT_BANNER_HEADING_2,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_2,
            CouponSettingConstant::INPUT_BANNER_IMG_2,
            CouponSettingConstant::INPUT_BANNER_URL_2,
            CouponSettingConstant::INPUT_BANNER_HEADING_3,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_3,
            CouponSettingConstant::INPUT_BANNER_IMG_3,
            CouponSettingConstant::INPUT_BANNER_URL_3,
            CouponSettingConstant::INPUT_BANNER_HEADING_4,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_4,
            CouponSettingConstant::INPUT_BANNER_IMG_4,
            CouponSettingConstant::INPUT_BANNER_URL_4,
            CouponSettingConstant::INPUT_BANNER_HEADING_5,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_5,
            CouponSettingConstant::INPUT_BANNER_IMG_5,
            CouponSettingConstant::INPUT_BANNER_URL_5,
            CouponSettingConstant::INPUT_BANNER_HEADING_6,
            CouponSettingConstant::INPUT_BANNER_EXPLAIN_6,
            CouponSettingConstant::INPUT_BANNER_IMG_6,
            CouponSettingConstant::INPUT_BANNER_URL_6
        ]);
        $listFile = [
            CouponSettingConstant::INPUT_FREE_IMG,
            CouponSettingConstant::INPUT_BANNER_IMG_1,
            CouponSettingConstant::INPUT_BANNER_IMG_2,
            CouponSettingConstant::INPUT_BANNER_IMG_3,
            CouponSettingConstant::INPUT_BANNER_IMG_4,
            CouponSettingConstant::INPUT_BANNER_IMG_5,
            CouponSettingConstant::INPUT_BANNER_IMG_6,
        ];
        foreach ($listFile as $file) {
            if (isset($input[$file])) {
                if ($request->hasFile($file)) {
                    $filePath = FileHelper::storage($input[$file]);
                    if (empty($filePath)) {
                        return redirect()
                            ->back()
                            ->with(KEY_NOTIFICATION, __('message.error.create'));
                    }
                    $input[$file] = $filePath;
                }
            }else {
                $input[$file] = null;
            }
        }
        $result = $this->couponSettingRepository->getCoupon($input);
        if ($result) {
            return redirect()
                ->route('coupon.couppon_setting')
                ->with(KEY_NOTIFICATION, __('message.success.create_success'));
        }
        Session::flash('error');
        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION,  __('message.error.create'));
    }
}
