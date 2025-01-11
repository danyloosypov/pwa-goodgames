<?php

namespace App\Shop\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Shop\Filters\AbstractFilter;
use ReflectionClass;
use ReflectionMethod;

trait HasFilters
{
    public function scopeFilter(Builder $builder, AbstractFilter $filters)
    {
        return $filters->filter($builder);
    }

    public function relationships()
    {
        $model = new static;

        $relationships = [];

        foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            
            if ($method->class != get_class($model) ||
                !empty($method->getParameters()) ||
                $method->getName() == __FUNCTION__) {
                continue;
            }

            try {
                $return = $method->invoke($model);

                if ($return instanceof Relation) {

                    $ownerKey = null;
                    if ((new ReflectionClass($return))->hasMethod('getOwnerKey')) {
                        $ownerKey = $return->getOwnerKey();
                    } else {
                        $segments = explode('.', $return->getQualifiedParentKeyName());
                        $ownerKey = $segments[count($segments) - 1];
                    }
                    // dd(new ReflectionClass($return));
                    $relationships[$method->getName()] = [
                        'model' => new ReflectionClass($return),
                        'name' => $method->getName(),
                        'type' => (new ReflectionClass($return))->getShortName(),
                        'model' => (new ReflectionClass($return->getRelated()))->getName(),
                        'foreignKey' => (new ReflectionClass($return))->hasMethod('getForeignKey')
                                ? $return->getForeignKey()
                                : ( 
                                    (new ReflectionClass($return))->hasMethod('getForeignKeyName')
                                    ? $return->getForeignKeyName() 
                                    : $return->getForeignPivotKeyName()),
                        'parentKey' => (new ReflectionClass($return))->hasMethod('getRelatedPivotKeyName') ? $return->getRelatedPivotKeyName() : '',
                        'ownerKey' => $ownerKey,
                        'table' => (new ReflectionClass($return))->hasMethod('getTable') ? $return->getTable() : '',
                    ];
                }
            } catch(ErrorException $e) {}
        }

        return $relationships;
    }
}