<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterManager
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected array $filters)
    {
        //
    }

    public function apply(Builder $builder, array $requestFilters)
    {
        foreach ($this->filters as $filterName => $filter) {
            if (isset($requestFilters[$filterName])) {
                $filter->apply($builder, $requestFilters[$filterName]);
            }
        }

        return $builder;
    }
}
