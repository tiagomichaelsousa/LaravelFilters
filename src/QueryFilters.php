<?php

namespace tiagomichaelsousa\LaravelFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilters
{
    /**
     * The request object.
     *
     * @var array
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new QueryFilters instance.
     *
     * @param Request|array $request
     */
    public function __construct($request = null)
    {
        if(is_null($request)) {
            $request = request();
        }
        $this->request = is_array($request) ? $request : (get_class($request) == Request::class ? $request->all() : []);
    }

    /**
     * Apply the filters to the builder.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (! method_exists($this, $filter)) {
                continue;
            }

            $this->$filter($value);
        }

        return $this->builder;
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request;
    }
}
