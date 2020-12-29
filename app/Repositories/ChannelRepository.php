<?php

namespace App\Repositories;

use App\Constants\OfficeConstant;
use App\Models\Channel;
use App\Models\Office;
use App\Models\Partner;
use App\Repositories\Base\BaseRepository;

class ChannelRepository extends BaseRepository implements IChannelRepository
{
    /**
     * Get model.
     *
     * @return mixed
     */
    protected function getModel()
    {
        return Channel::class;
    }

    /**
     * Get list of channel.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL)
    {
        return Channel::query()
            ->select($columns)
            ->whereNull(FIELD_DELETED_AT)
            ->get();
    }
}
