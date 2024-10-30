<?php

namespace App\Filters;

use Illuminate\DAtabase\Eloquent\Builder;

abstract class BaseFilter
{
    abstract public function apply(Builder $builder, $value);
}
