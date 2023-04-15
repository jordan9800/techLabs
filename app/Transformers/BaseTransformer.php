<?php


namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class BaseTransformer
{


    /**
     * Transform collection
     *
     * @param Collection $items
     * @param array      $relations
     * @param            $includeExtras
     * @return array
     */
    public function transformCollection(Collection $items, array $relations = [], $includeExtras = false)
    {
        return $items->transform(function ($item, $key) use ($relations, $includeExtras) {
            return $this->transform($item, $relations, $includeExtras);
        });
    }


    /**
     * @param LengthAwarePaginator $lengthAwarePaginator
     * @param array                $relations
     * @param bool                 $includeExtras
     * @return array
     */
    public function transformPaginationList(LengthAwarePaginator $lengthAwarePaginator, array $relations = [], $includeExtras = false)
    {
        return [
            'data'          => $this->transformCollection($lengthAwarePaginator->getCollection(), $relations, $includeExtras),
            'meta'          => [
                'current_page'  => $lengthAwarePaginator->currentPage(),
                'from'          => $lengthAwarePaginator->firstItem(),
                'last_page'     => $lengthAwarePaginator->lastPage(),
                'next_page_url' => $lengthAwarePaginator->nextPageUrl(),
                'per_page'      => $lengthAwarePaginator->perPage(),
                'prev_page_url' => $lengthAwarePaginator->previousPageUrl(),
                'to'            => $lengthAwarePaginator->lastItem(),
                'total'         => $lengthAwarePaginator->total(),       
            ]
        ];
    }


    /**
     * @param Model $item
     * @param       $relations
     * @param       $includeExtras
     * @return array
     */
    abstract public function transform(Model $item, $relations, $includeExtras);

}