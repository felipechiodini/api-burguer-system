<?php

namespace App\Table;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Table
{
    private $eloquentBuilder;
    private $columns;
    private $perPage;
    private $filters;
    private $modifiers;

    public function __construct()
    {
        $this->columns = collect([]);
        $this->modifiers = collect([]);
        $this->filters = collect([]);
    }

    public static function make()
    {
        return new static();
    }

    public function setEloquentBuilder(Builder $eloquentBuilder)
    {
        $this->eloquentBuilder = $eloquentBuilder;
        return $this;
    }

    public function addModifier(String $column, Closure $closure): Self
    {
        $this->modifiers->put($column, $closure);
        return $this;
    }

    public function addColumn(String $label): Self
    {
        $this->columns->push($label);
        return $this;
    }

    public function setPerPage(Int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function addFilter(Filter $filter)
    {
        $this->filters->push($filter);
        return $this;
    }

    private function getEloquentWithFilters(): Builder
    {
        $this->filters
            ->each(function(Filter $filter) {
                if ($filter->hasValue()) {
                    $filter->apply($this->eloquentBuilder);
                }
            });

        return $this->eloquentBuilder;
    }

    public function get()
    {
        $page = $this->getEloquentWithFilters()
            ->paginate($this->perPage ?? 10);

        $page->transform(function($model) {
            $this->modifiers
                ->keys()
                ->each(function($key) use($model) {
                    $callback = $this->modifiers->get($key);

                    if ($callback !== null) {
                        $model[$key] = $callback($model[$key]);
                    }
                });

            return $model;
        });

        return [
            'page' => $page,
            'columns' => $this->columns,
            'filters' => $this->filters
        ];
    }

}
