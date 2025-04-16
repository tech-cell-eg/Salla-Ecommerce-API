<?php

namespace App\Traits;

use App\Helpers\QueryFilter;


trait FilterTrait
{
    // scope method to filter queries
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}