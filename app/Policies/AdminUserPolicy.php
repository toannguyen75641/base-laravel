<?php

namespace App\Policies;

use App\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin user can delete the other admin user.
     *
     * @param AdminUser $auth
     * @param AdminUser $adminUser
     *
     * @return mixed
     */
    public function delete(AdminUser $auth, AdminUser $adminUser)
    {
        return $auth->id != $adminUser->id;
    }
}
