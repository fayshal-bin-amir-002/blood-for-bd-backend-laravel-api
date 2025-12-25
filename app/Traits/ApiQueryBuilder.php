<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait ApiQueryBuilder
{
  public function scopeApiQuery(Builder $query, Request $request, array $searchableFields = []) {
    // for search
    if($request->filled('search') && !empty($searchableFields)) {
      $query->where(function($q) use ($request, $searchableFields) {
        foreach($searchableFields as $field) {
          $q->orWhere($field, 'like', '%' . $request->search . '%');
        }
      });
    }
    // for filter
    $filters = $request->except(['search', 'page', 'limit', 'sort_by', 'sort_order']);
    foreach ($filters as $key => $value) {
      if ($value !== null && $value !== '') {
        $query->where($key, $value);
      }
    }
    // for sorting
    $sortBy = $request->query('sort_by', 'id');
    $sortOrder = $request->query('sort_order', 'desc');
    $query->orderBy($sortBy, in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc');

    // for limit
    $limit = min($request->query('limit', 10), 100);

    // return the final query
    return $query->paginate($limit);
  }
}
