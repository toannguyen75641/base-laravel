<?php

namespace App\Models;

use App\Constants\CouponConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CouponManagement
 *
 * @package App\Models
 *
 * @property int id
 * @property int channels_id
 * @property int partners_id
 * @property int coupon_masters_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class CouponManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon_managements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channels_id',
        'partners_id',
        'coupon_masters_id'
    ];

    /**
     * Get the coupon_managements for the coupon_masters.
     *
     * @return BelongsTo
     */
    public function coupon_master()
    {
        return $this->belongsTo(CouponMaster::class, 'coupon_masters_id');
    }

    /**
     * Get the coupon_managements for the channels.
     *
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channels_id');
    }

    /**
     * Get the coupon_managements for the partners.
     *
     * @return BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partners_id');
    }

    /**
     * Get the id and name partner.
     *
     * @return int
     */
    public function getNamePartnerAttribute()
    {
        return  "{$this->partners_id}　{$this->partner->name}";
    }

    /**
     * Get the id and name channel.
     *
     * @return int
     */
    public function getNameChannelAttribute()
    {
        return  "{$this->channels_id}　{$this->channel->name}";
    }

    /**
     * Get the id and name coupon_master.
     *
     * @return int
     */
    public function getNameCouponMasterAttribute()
    {
        return  "{$this->coupon_masters_id}　{$this->coupon_master->measure_name}";
    }
}
