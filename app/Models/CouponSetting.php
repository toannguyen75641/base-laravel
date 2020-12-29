<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CouponSetting
 *
 * @package App\Models
 *
 * @property int id
 * @property int coupon_masters_id
 * @property string code
 * @property bool flg
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class CouponSetting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon_common_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'free_img',
        'free_url',
        'button_url',
        'banner_heading_1',
        'banner_explain_1',
        'banner_img_1',
        'banner_url_1',
        'banner_heading_2',
        'banner_explain_2',
        'banner_img_2',
        'banner_url_2',
        'banner_heading_3',
        'banner_explain_3',
        'banner_img_3',
        'banner_url_3',
        'banner_heading_4',
        'banner_explain_4',
        'banner_img_4',
        'banner_url_4',
        'banner_heading_5',
        'banner_explain_5',
        'banner_img_5',
        'banner_url_5',
        'banner_heading_6',
        'banner_explain_6',
        'banner_img_6',
        'banner_url_6',
    ];
}
