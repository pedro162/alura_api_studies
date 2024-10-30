<?php

namespace App\Filters;

use Illuminate\DAtabase\Eloquent\Builder;

class NameFilter extends BaseFilter
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('name', 'like', "%{$value}%");
    }
}
