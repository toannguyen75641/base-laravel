<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Region
 *
 * @package App\Models\AdminUser
 *
 * @property string name
 * @property int offices_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Region extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'offices_id'
    ];

    /**
     * Get the office for the region.
     *
     * @return BelongsTo
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'offices_id');
    }
}
