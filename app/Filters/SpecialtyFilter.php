<?php

namespace App\Filters;

use Fguzman\Sortable;
use Fguzman\QueryFilter;
use Fguzman\Rules\SortableColumn;

class SpecialtyFilter extends QueryFilter
{
    protected $aliases = [];

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'sort'    => [new SortableColumn([
                            'name',
                            'description',
                            'created_at',
                        ])],
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('created_at', 'like', "%{$search}%");
        });
    }

    public function sort($query, $value)
    {
        [$column, $direction] = Sortable::info($value);

        $query->orderBy($this->getColumnName($column), $direction);
    }

    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }
}
