<?php

namespace App\Models;

use App\Constants\BusinessUserConstant;
use App\Helpers\StringHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BusinessUser
 *
 * @package App\Models
 *
 * @property string user_id
 * @property bool authority
 * @property string name
 * @property string password
 * @property bool locked
 * @property Carbon lock_date
 * @property int failed_count
 * @property Carbon last_login_date
 * @property int offices_id
 * @property int regions_id
 * @property int departments_id
 * @property int sales_persons_id
 * @property int status
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class BusinessUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'authority',
        'name',
        'password',
        'locked',
        'lock_date',
        'failed_count',
        'last_login_date',
        'offices_id',
        'regions_id',
        'departments_id',
        'status',
        'deleted_at',
        'sales_persons_id'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'locked' => BusinessUserConstant::UNLOCK,
        'failed_count' => 0,
        'status' => BusinessUserConstant::STATUS_ACTIVE,
        'deleted_at' => null
    ];

    /**
     * Set the business user's password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPasswordAttribute(?string $password)
    {
        if (!is_null($password)) {
            $this->attributes['password'] = StringHelper::hash($password);
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the office for the business user.
     *
     * @return belongsTo
     */
    public function offices()
    {
        return $this->belongsTo(Office::class, 'offices_id');
    }

    /**
     * Get the regions for the business user.
     *
     * @return belongsTo
     */
    public function regions()
    {
        return $this->belongsTo(Region::class, 'regions_id');
    }

    /**
     * Get the departments for the business user.
     *
     * @return BelongsTo
     */
    public function departments()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }

    /**
     * Get the sales persons for the business user.
     *
     * @return BelongsTo
     */
    public function salesPersons()
    {
        return $this->belongsTo(SalesPerson::class, 'sales_persons_id');
    }
}
