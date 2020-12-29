<?php

namespace App\Repositories;

use App\Constants\OfficeConstant;
use App\Models\Office;
use App\Models\Partner;
use App\Repositories\Base\BaseRepository;

class PartnerRepository extends BaseRepository implements IPartnerRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Partner::class;
    }

    /**
     * Get list of partners.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL)
    {
        return Partner::query()
            ->select($columns)
            ->whereNull(FIELD_DELETED_AT)
            ->get();
    }
}
