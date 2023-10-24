<?php

namespace App\Helpers;

class Pagination
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    

    /**
     * Paginate results.
     * 
     * @param int $page
     * @param int $numberOfResults
     * @param string $orderBy
     * @param string $order
     * @param string $search
     */
    public function paginate(int $page, int $numberOfResults, string $orderBy, string $order, string $search = null)
    {
        $model = new $this->model;
        $searchColumns = $model->getFillable();

        $orderTypes = ['asc', 'desc'];
        $orderByOptions = $model->getFillable();
        array_push($orderByOptions, 'id');

        if(!in_array(strtolower($order), $orderTypes)) return false;
        if(!in_array(strtolower($orderBy), $orderByOptions)) return false;

        if($page < 1) return false;
        if($numberOfResults < 1) return false;
        

        $allItems = $this->model::orderBy($orderBy, $order)
                ->skip($page * $numberOfResults - $numberOfResults)
                ->take($numberOfResults)
                ->where(function($query) use($searchColumns, $search){
                    foreach($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, "like", '%' . $search . '%');
                    }
                    return $query;
                })
                ->select("*")
                ->get();

        $totalItems = $this->model::orderBy('id', 'desc')
            ->where(function($query) use($searchColumns, $search){
                foreach($searchColumns as $searchColumn) {
                    $query->orWhere($searchColumn, "like", '%' . $search . '%');
                }
                return $query;
            })
            ->select("*")
            ->get();

        $numberOfPages = ceil($totalItems->count() / $numberOfResults);

        $pages = array();
        for($i = 1; $i <= $numberOfPages; $i++){
            array_push($pages, $i);
        }

        $results = $allItems->toArray();

        $response["numberOfPages"] = $pages;
        $response["results"] = $results;
        return $response;
    }
}