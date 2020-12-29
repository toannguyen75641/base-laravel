<?php

namespace App\Models;

use App\Constants\CouponConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CouponMaster
 *
 * @package App\Models
 *
 * @property string measure_code
 * @property Carbon sys_period_from
 * @property Carbon sys_period_to
 * @property string name
 * @property Carbon open_date
 * @property Carbon period_from
 * @property Carbon period_to
 * @property bool flg
 * @property string benefit_amount
 * @property string coupon_img
 * @property string explain
 * @property string link_text_1
 * @property string link_url_1
 * @property string link_text_2
 * @property string link_url_2
 * @property string link_text_3
 * @property string link_url_3
 * @property string coupon_name
 * @property string benefit_explain
 * @property string target
 * @property string condition
 * @property string caution
 * @property string heading_1
 * @property string heading_2
 * @property string note
 * @property string message
 * @property string sms_message
 * @property bool forced_offices_flg
 * @property bool forced_sales_persons_flg
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class CouponMaster extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon_masters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'measure_code',
        'sys_period_from',
        'sys_period_to',
        'name',
        'open_date',
        'period_from',
        'period_to',
        'flg',
        'benefit_amount',
        'coupon_img',
        'explain',
        'link_text_1',
        'link_url_1',
        'link_text_2',
        'link_url_2',
        'link_text_3',
        'link_url_3',
        'coupon_name',
        'benefit_explain',
        'target',
        'condition',
        'caution',
        'heading_1',
        'heading_2',
        'note',
        'message',
        'sms_message',
        'forced_offices_flg',
        'forced_sales_persons_flg'
    ];

    /**
     * Get the coupons for the coupon_masters.
     *
     * @return HasMany
     */
    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'coupon_masters_id');
    }

    /**
     * Get the coupon master's quantity.
     *
     * @return int
     */
    public function getCouponCountAttribute()
    {
        return $this->coupons()->count();
    }

    /**
     * Get the coupon master's quantity which has unissued flag.
     *
     * @return int
     */
    public function getCouponFlgCountAttribute()
    {
        return $this->coupons()->where('flg', CouponConstant::FLG_UNISSUED)->count();
    }
}
