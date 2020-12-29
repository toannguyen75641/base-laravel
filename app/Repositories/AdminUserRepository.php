<?php

namespace App\Repositories;

use App\Constants\AdminUserConstant;
use App\Models\AdminUser;
use App\Repositories\Base\BaseRepository;

class AdminUserRepository extends BaseRepository implements IAdminUserRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return AdminUser::class;
    }

    /**
     * Get list of admin users.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [])
    {
        $query = AdminUser::query();
        $query->whereNull(AdminUserConstant::INPUT_DELETE_AT);
        $query->where(function ($query) use ($condition) {
            foreach ($condition as $column => $value) {
                if (!is_null($value)) {
                    $operator = $column === AdminUserConstant::INPUT_STATUS ? OPERATOR_EQUAL : OPERATOR_LIKE;
                    $value = $column === AdminUserConstant::INPUT_STATUS ? $value : "%{$value}%";
                    $query->where($column, $operator, $value);
                }
            }
        });

        return $query->paginate(PAGE_SIZE_20, $columns);
    }

    /**
     * Get admin user detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL)
    {
        return parent::getDetail($id, $columns)
            ->whereNull(AdminUserConstant::INPUT_DELETE_AT)
            ->first();
    }

    /**
     * Delete admin user.
     *
     * @param $id
     * @param $auth
     *
     * @return mixed
     */
    public function delete($id, $auth)
    {
        $result = null;

        $adminUser = $this->getDetail($id, [
            FIELD_ID,
            AdminUserConstant::INPUT_DELETE_AT
        ]);
        if ($adminUser && $auth->can('delete', $adminUser)) {
            $input = [
                FIELD_ID => $id,
                AdminUserConstant::INPUT_DELETE_AT => now()
            ];
            $result = $this->update($adminUser, $input);
        }

        return $result;
    }
}
