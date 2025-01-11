<?php

namespace App\Shop\Filters;

use Exception;
use Illuminate\Http\Request;

class Slug
{
    private $request;
    public $requestParameters;
    public $params;

    public function __construct(Request $request, $params)
    {   
        $this->request = $request;
        $this->requestParameters = $request->route()->parameters ?? [];
        $this->params = $params;
    }

    public function getFilters()
    {
        $filters = [];

        foreach ($this->params as $key => $param) {
            $filters[$key] = [
                'key'   => 'id',
                'value' => $param,
            ];
        }

        if (!isset($this->requestParameters['slug'])) {
            foreach ($this->requestParameters as $key => &$requestParameter) {
                $filters[$key] = [
                    'key'   => 'slug',
                    'value' => $requestParameter,
                ];
            }
            return $filters;
        }

        if (empty($this->request->slug)) {
            return $filters;
        }

        try {

            $parts = explode('/', $this->request->slug);

            foreach ($parts as $part) {

                $filter = explode('--', $part);
                
                if (sizeof($filter) != 2) {
                    throw new Exception('Bad slug');
                }

                $filters[$filter[0]] = [
                    'key'       => 'slug',
                    'value'     => $filter[1]
                ];
            }

        } catch (Exception $e) {
            // abort(404);
        }

        return $filters;
    }

    public function getSort() 
    {
        return $this->request->all();
    }
}