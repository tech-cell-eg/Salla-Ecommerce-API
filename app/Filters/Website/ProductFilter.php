<?php

namespace App\Filters\Website;

use App\Helpers\QueryFilter;

class ProductFilter extends QueryFilter
{
    public function category_id($id)
    {
        return $this->builder->where('category_id', $id);
    }

    public function brand_id($id)
    {
        return $this->builder->where('brand_id', $id);
    }

    public function min_price($start)
    {
        $end = request('max_price');
        if ($end) {
            return $this->builder->whereBetween('price', [$start, $end]);
        }
        return $this->builder;
    }
}
