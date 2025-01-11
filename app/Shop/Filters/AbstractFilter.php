<?php

namespace App\Shop\Filters;

use App\Shop\Filters\Slug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DB;
use Lang;
use ReflectionClass;

abstract class AbstractFilter
{
    protected $filters = [];
    protected $sort = [];
    protected $model;
    protected $slug;
    protected $request;

    public function __construct(Request $request, $params = [])
    {   
        $this->slug = new Slug($request, $params);
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {   
        foreach ($this->getFilters() as $filter => $value) {
            $this->builder($this->resolveFilter($filter), $builder, $filter, $value);
        }

        foreach ($this->getSort() as $sort => $value) {
            if ($this->isSort($sort, $value)) {
                if ($builder->getModel() instanceof \App\Models\Catalog\Product && $sort == 'price') {
                    if (!Collection::make($builder->getQuery()->joins)->pluck('table')->contains('promotions AS prom')) {
                        $builder->leftJoin('promotions AS prom', 'products_'.Lang::get().'.id', 'prom.id_products');
                    }
                    $builder = $builder->orderByRaw('COALESCE(prom.price, products_'.Lang::get().'.price) '.$value);
                } else {
                    $builder->orderBy($sort, $value);
                }
            }
        }

        return $builder;
    }

    private function builder($model, $builder, $key, $value)
    {
        $relationships = $this->resolveModel()->relationships();

        if (isset($relationships[$key]) && $relationships[$key]['type'] == 'BelongsTo') {
            $relationItem = $model->whereIn($value['key'], $value['value'])->get();
            $ids = $relationItem->pluck('id')->all();

            if ((new ReflectionClass($model))->hasMethod('children')) {
                foreach ($relationItem as $relationItemFirst) {
                    $ids = array_merge($ids, $relationItemFirst->getDescendants($relationItemFirst));
                }
            }
            
            if (!empty($ids)) {
                return $builder->whereIn($relationships[$key]['foreignKey'], $ids);
            }

        } elseif ($relationships[$key]['type'] == 'BelongsToMany') {

            $ids = DB::table($relationships[$key]['table'])
            ->whereIn($relationships[$key]['parentKey'], $value['value'])
            ->get([$relationships[$key]['foreignKey']])
            ->pluck($relationships[$key]['foreignKey']);
            
            return $builder->whereIn($relationships[$key]['ownerKey'], $ids);
        }
    }

    public function getFilters()
    {
        return $this->slug->getFilters();
    }

    public function getSort() 
    {
        $sorts = $this->slug->getSort();

        foreach ($this->slug->getSort() as $sort => $value) {
            if (!$this->isSort($sort, $value)) {
                unset($sorts[$sort]);
            }
        }

        return $sorts;
    }

    public function isSort($sort, $value) 
    {
        if (!in_array($sort, $this->sort) || !in_array($value, ['asc', 'desc'])) {
            return false;
        }

        return true;
    }

    protected function resolveFilter($filter)
    {
        if (!isset($this->filters[$filter])) {
            abort(404);
        }

        return new $this->filters[$filter];
    }

    protected function resolveModel()
    {
        return new $this->model;
    }
}