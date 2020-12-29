<?php

namespace App\Repositories;

interface IPartnerRepository
{
    /**
     * Get list of partners.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL);
}
