<?php

namespace App\Helpers;

class PaginationHelper
{
    /**
     * This function returns per page from request or returns default value
     *
     * @param int $default
     * @param string $requestKey
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function getPerPage(int $default = 5, string $requestKey = 'per_page', int $min = 1, int $max = 100): int
    {
        $perPage = intval(request()->get($requestKey));
        return $min <= $perPage && $perPage <= $max ? $perPage : $default;
    }
}
