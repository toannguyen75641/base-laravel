<?php

namespace App\Repositories;

interface ISalesPersonRepository
{
    /**
     * Get list of sales persons.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL);
}
