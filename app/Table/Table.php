<?php

namespace App\Table;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Table {

    private $query;
    private $columns;
    private $perPage;
    private $filters;

    public function __construct()
    {
        $this->columns = collect([]);
    }

    public static function make()
    {
        return new static();
    }

    public function setQuery(Builder $query)
    {
        $this->query = $query;
        return $this;
    }

    public function addColumn($name, $label, $modifier = null)
    {
        $this->columns->put($name, [
            'label' => $label,
            'modifier' => $modifier
        ]);

        return $this;
    }

    public function setPerPage(Int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function get()
    {
        $query = $this->query
            ->select($this->columns->keys()->toArray());

        if ($this->filters !== null) {
            foreach ($this->filters as $filter) {
                $filter = json_decode($filter);
                $where = new WhereResolver($filter->operator, $filter->value);
                $query->where($filter->name, $where->getOperator(), $where->getValue());
            }
        }

        $page = $query->orderBy('id', 'desc')
            ->paginate($this->perPage ?? 10);

        foreach ($page->items() as $item) {
            $this->columns->keys()
                ->each(function($key) use($item) {
                    $callback = $this->columns->get($key)['modifier'];

                    if ($callback !== null) {
                        $item[$key] = $callback($item[$key]);
                    }
                });
        }

        $columns = $this->columns
            ->keys()
            ->map(function($key) {
                return [
                    'name' => $key,
                    'label' => $this->columns->get($key)['label']
                ];
            });

        return [
            'page' => $page,
            'columns' => $columns
        ];
    }

}
