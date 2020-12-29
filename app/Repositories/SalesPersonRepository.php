<?php

namespace App\Repositories;

use App\Constants\SalesPersonConstant;
use App\Models\SalesPerson;
use App\Repositories\Base\BaseRepository;

class SalesPersonRepository extends BaseRepository implements ISalesPersonRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return SalesPerson::class;
    }

    /**
     * Get list of sales persons.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL)
    {
        return SalesPerson::query()
            ->select($columns)
            ->whereNull(SalesPersonConstant::INPUT_DELETE_AT)
            ->with('department')
            ->get();
    }
}
