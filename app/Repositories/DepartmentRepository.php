<?php

namespace App\Repositories;

use App\Constants\DepartmentConstant;
use App\Constants\OfficeConstant;
use App\Constants\RegionConstant;
use App\Models\Department;
use App\Models\Office;
use App\Models\Region;
use App\Repositories\Base\BaseRepository;

class DepartmentRepository extends BaseRepository implements IDepartmentRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Department::class;
    }

    /**
     * Get list of departments.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [])
    {
        $query = Department::query()
            ->whereNull(DepartmentConstant::INPUT_DELETED_AT)
            ->select($columns)
            ->with('region');
        if (isset($condition[RegionConstant::INPUT_OFFICES_ID])) {
            $listRegion = $this->getRegion(RegionConstant::INPUT_OFFICES_ID, $condition[RegionConstant::INPUT_OFFICES_ID]);
            $query->whereIn(DepartmentConstant::INPUT_REGIONS_ID, $listRegion);
        }
        if (isset($condition[DepartmentConstant::INPUT_REGIONS_ID])) {
            $query->where(DepartmentConstant::INPUT_REGIONS_ID, OPERATOR_EQUAL, $condition[DepartmentConstant::INPUT_REGIONS_ID]);
        }
        if (isset($condition[DepartmentConstant::INPUT_ID])) {
            $query->where(DepartmentConstant::INPUT_ID, OPERATOR_EQUAL, $condition[DepartmentConstant::INPUT_ID]);
        }
        if (isset($condition[OfficeConstant::INPUT_NAME]) && !empty($condition[OfficeConstant::INPUT_NAME])) {
            $listRegion = $this->getRegion(OfficeConstant::INPUT_NAME, $condition[OfficeConstant::INPUT_NAME]);
            $query->whereIn(DepartmentConstant::INPUT_REGIONS_ID, $listRegion);
        }
        if (isset($condition[OfficeConstant::INPUT_CODE]) && !empty($condition[OfficeConstant::INPUT_CODE])) {
            $listRegion = $this->getRegion(OfficeConstant::INPUT_CODE, $condition[OfficeConstant::INPUT_CODE]);
            $query->whereIn(DepartmentConstant::INPUT_REGIONS_ID, $listRegion);
        }

        return $query->paginate(PAGE_SIZE_20);
    }

    /**
     * Get department detail.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getDetail($id, array $columns = SELECT_ALL)
    {
        return parent::getDetail($id, $columns)
            ->whereNull(DepartmentConstant::INPUT_DELETED_AT)
            ->first();
    }

    /**
     * Get list region
     *
     * @param $column
     * @param $condition
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getRegion($column, $condition)
    {
        $query = Region::query()->select(FIELD_ID);
        if ($column === RegionConstant::INPUT_OFFICES_ID) {
            $query->where($column,  $condition)
                ->get()->toArray();
        } else {
            $query->whereIn(RegionConstant::INPUT_OFFICES_ID,
                Office::query()->select(FIELD_ID)
                    ->where($column, OPERATOR_LIKE, '%'.$condition.'%')
                    ->get()->toArray());
        }

        return $query;
    }

    /**
     * Delete department.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $result = null;

        $department = $this->getDetail($id);
        if ($department) {
            $result = $this->update($department, [
                DepartmentConstant::INPUT_DELETED_AT => now()
            ]);
        }

        return $result;
    }
}
