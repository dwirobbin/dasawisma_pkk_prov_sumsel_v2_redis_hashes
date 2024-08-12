<?php

namespace App\Helpers;

use Illuminate\Pagination\Paginator;

class LengthPager
{
    public static function paginate($paginationData)
    {
        $paginator = new Paginator(
            $paginationData['data'],
            $paginationData['per_page'],
            $paginationData['current_page'],
            ['path' => Paginator::resolveCurrentPath()]
        );

        if (isset($paginationData['hasMore'])) {
            $paginator->hasMorePagesWhen($paginationData['hasMore']);
        } else {
            $paginator->hasMorePagesWhen($paginationData['next_page_url'] != null);
        }

        return $paginator;
    }
}
