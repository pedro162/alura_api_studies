<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class IdFilter extends BaseFilter
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereIn('id', [...explode(',', $value)]);
    }
}
