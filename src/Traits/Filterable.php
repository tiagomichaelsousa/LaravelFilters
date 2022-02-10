<?php

namespace tiagomichaelsousa\LaravelFilters\Traits;

use Illuminate\Database\Eloquent\Builder;
use tiagomichaelsousa\LaravelFilters\QueryFilters;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder  $query
     * @param  QueryFilters  $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Return all results or a paginator.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeResolve(Builder $query)
    {
        return request()->paginate ? $query->paginate(request()->paginate) : $query->get();
    }
}
