<?php

namespace App\Repositories;

interface IChannelRepository
{
    /**
     * Get list of channel.
     *
     * @param array $columns
     * @param array $condition
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL);
}
