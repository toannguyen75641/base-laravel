<?php

namespace App\Repositories;

use App\Models\BusinessUser;
use App\Repositories\Base\BaseRepository;
use App\Constants\BusinessUserConstant;

class BusinessUserRepository extends BaseRepository implements IBusinessUserRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return BusinessUser::class;
    }

    /**
     * Get all of business users.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getAll(array $columns = SELECT_ALL)
    {
        return BusinessUser::query()
            ->select($columns)
            ->with('offices', 'regions', 'departments', 'salesPersons')
            ->get();
    }

    /**
     * Get list of business users.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [])
    {
        $query = BusinessUser::query()
            ->with('offices', 'regions', 'departments', 'salesPersons')
            ->whereNull(BusinessUserConstant::INPUT_DELETE_AT);
        if (isset($condition[BusinessUserConstant::INPUT_OFFICES_ID])) {
            $query->where(BusinessUserConstant::INPUT_OFFICES_ID, OPERATOR_EQUAL, $condition[BusinessUserConstant::INPUT_OFFICES_ID]);
        }
        if (isset($condition[BusinessUserConstant::INPUT_REGIONS_ID])) {
            $query->where(BusinessUserConstant::INPUT_REGIONS_ID, OPERATOR_EQUAL, $condition[BusinessUserConstant::INPUT_REGIONS_ID]);
        }
        if (isset($condition[BusinessUserConstant::INPUT_DEPARTMENTS_ID])) {
            $query->where(BusinessUserConstant::INPUT_DEPARTMENTS_ID, OPERATOR_EQUAL, $condition[BusinessUserConstant::INPUT_DEPARTMENTS_ID]);
        }
        if (isset($condition[BusinessUserConstant::INPUT_NAME]) && !empty($condition[BusinessUserConstant::INPUT_NAME])) {
            $query->where(BusinessUserConstant::INPUT_NAME, OPERATOR_LIKE, '%'.$condition[BusinessUserConstant::INPUT_NAME].'%');
        }
        if (isset($condition[BusinessUserConstant::INPUT_AUTHORITY])) {
            $query->where(BusinessUserConstant::INPUT_AUTHORITY, OPERATOR_EQUAL, $condition[BusinessUserConstant::INPUT_AUTHORITY]);
        }
        if (isset($condition[BusinessUserConstant::INPUT_STATUS])) {
            $query->where(BusinessUserConstant::INPUT_STATUS, OPERATOR_EQUAL, $condition[BusinessUserConstant::INPUT_STATUS]);
        }

        return $query->paginate(PAGE_SIZE_50, $columns);
    }

    /**
     * Get business user detail.
     *
     * @param $id
     * @param array $columns
     * @param $deletedAt
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL, $deletedAt = false)
    {
        $query = parent::getDetail($id, $columns);
        if(!$deletedAt) {
            $query->whereNull(BusinessUserConstant::INPUT_DELETE_AT);
        }
        return $query->first();
    }

    /**
     * Delete business user.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $result = null;

        $businessUser = $this->getDetail($id, [
            FIELD_ID,
            BusinessUserConstant::INPUT_DELETE_AT
        ]);
        if ($businessUser) {
            $result = $this->update($businessUser, [
                BusinessUserConstant::INPUT_DELETE_AT => now()
            ]);
        }

        return $result;
    }
}