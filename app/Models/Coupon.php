<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
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
class Coupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coupon_masters_id',
        'code',
        'flg'
    ];
}
