<?php

namespace App\Models;

use App\Constants\AdminUserConstant;
use App\Helpers\StringHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

/**
 * Class AdminUser
 *
 * @package App\Models\AdminUser
 *
 * @property string user_id
 * @property string name
 * @property string password
 * @property bool status
 * @property bool locked
 * @property Carbon lock_date
 * @property int failed_count
 * @property Carbon last_login_date
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class AdminUser extends Authenticatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'password',
        'status',
        'locked',
        'lock_date',
        'position',
        'failed_count',
        'last_login_date',
        'deleted_at'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'locked' => AdminUserConstant::UNLOCK,
        'failed_count' => 0,
        'status' => AdminUserConstant::STATUS_ACTIVE,
        'deleted_at' => null
    ];

    /**
     * Set the admin user's password.
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

    public function getAdmin($userId)
    {
        return $this->where('user_id', $userId)
            ->whereNull(AdminUserConstant::INPUT_DELETE_AT)
            ->first();
    }

    public function updateAdmin($data, $key)
    {
        return $this->where('id', $key)
            ->whereNull(AdminUserConstant::INPUT_DELETE_AT)
            ->update($data);
    }
}
