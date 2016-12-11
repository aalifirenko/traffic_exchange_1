<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function scanAllForMatch($pattern, $cursor = null, $allResults = array())
    {
        if ($cursor === "0") {
            return $allResults;
        }
        if ($cursor === null) {
            $cursor = "0";
        }
        $result = Redis::scan($cursor, 'match', $pattern);
        $allResults = array_merge($allResults, $result[1]);
        return self::scanAllForMatch($pattern, $result[0], $allResults);
    }

    protected function helperPageProvider()
    {
        $result = [];
        $currentPages = Redis::keys('page:*');
        foreach ($currentPages as $pageItem) {
            $data = explode ( ':', $pageItem );
            $result[] = [
                'page_id' => $data[1],
                'page_uhash' => Redis::hget("page:".$data[1], "uhash"),
            ];
        }
        return $result;
    }

    protected function helperGetSummary()
    {
        $result = [];
        $currentPages = Redis::keys('page:*');
        foreach ($currentPages as $pageItem) {
            $data = explode ( ':', $pageItem );
            $result[] = [$data[1]];
        }
        return $result;
    }
}
