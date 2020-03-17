<?php

namespace tiagomichaelsousa\LaravelFilters\Tests\Filters;

use tiagomichaelsousa\LaravelFilters\QueryFilters;

class UserFilters extends QueryFilters
{
    /**
     * Search all.
     *
     * @param  string  $query
     * @return Builder
     */
    public function search($value = '')
    {
        return $this->builder->where('name', 'like', '%' . $value . '%')
                            ->orWhere('last_name', 'like', '%' . $value . '%');
    }

    /**
     * Search all.
     *
     * @param  string  $query
     * @return Builder
     */
    public function last_name($value = '')
    {
        return $this->builder->where('last_name', $value);
    }
}
