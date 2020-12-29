<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Office
 *
 * @package App\Models\AdminUser
 *
 * @property string name
 * @property int partner
 * @property string code
 * @property string logo
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Office extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'partner',
        'code',
        'logo',
        'deleted_at'
    ];

    /**
     * Get the regions for the office.
     *
     * @return HasMany
     */
    public function regions()
    {
        return $this->hasMany(Region::class, 'offices_id');
    }
}
