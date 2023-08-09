<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterableTrait
{
    public function scopeFilter(Builder $query, $search, $columns = [])
    {
        $query->when($search, function ($query, $search) use ($columns) {
            $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            });
        });
    }
}
