<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Department
 *
 * @package App\Models\AdminUser
 *
 * @property string name
 * @property int regions_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'regions_id'
    ];

    /**
     * Get the deparments for the sale_person.
     *
     * @return BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'regions_id');
    }
}
