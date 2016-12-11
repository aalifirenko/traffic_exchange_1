<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StatisticHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Config;

class DashboardController extends AdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->menu_config_name = 'menu.admin';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config_pages = config('menu.public');

        foreach ($config_pages as $pageId => $params) {
            $page = 'page:'.$pageId;
            $pageHashItem = md5($params['title']);

            if(Redis::hexists( $page, 'id') == null) {
                Redis::hset( $page, 'id', $pageId );
                Redis::hset( $page, 'uhash', $pageHashItem );
            }
        }

        return view('admin/dashboard', [
            'menu_config_name' => $this->menu_config_name,
            'pages' => $this->helperPageProvider(),
        ]);
    }

    public function showStat($page_id)
    {
        return view('admin/page_stat', [
            'pages' => $this->helperPageProvider(),
            'page_id' => $page_id,
            'browsers' => $this->scanAllForMatch("stat:page:".$page_id.":browser:*:ip"),
            'platforms' => $this->scanAllForMatch("stat:page:".$page_id.":os:*:ip"),
            'geodata' => $this->scanAllForMatch("stat:page:".$page_id.":geo:*:ip"),
            'refs' => $this->scanAllForMatch("stat:page:".$page_id.":ref:*:ip"),
            'menu_config_name' => $this->menu_config_name,
        ]);
    }

    public function summary()
    {
        return view('admin/total_page_stat', [
            'pages' => $this->helperPageProvider(),
            'page_id' => 'summary',
            'browsers' => $this->scanAllForMatch("stat:page:summary:browser:*:ip"),
            'platforms' => $this->scanAllForMatch("stat:page:summary:os:*:ip"),
            'geodata' => $this->scanAllForMatch("stat:page:summary:geo:*:ip"),
            'refs' => $this->scanAllForMatch("stat:page:summary:ref:*:ip"),
            'menu_config_name' => $this->menu_config_name,
        ]);
    }

    public function details(Request $request)
    {
        $browsers = $this->scanAllForMatch("stat:page:summary:browser:*:ip");
        $os_list = $this->scanAllForMatch("stat:page:summary:os:*:ip");
        $ref_list = $this->scanAllForMatch("stat:page:summary:ref:*:ip");
        $pages = config('menu.public');

        $uniqBrowsers = StatisticHelper::getUniqBrowsers($browsers);
        $uniqOS = StatisticHelper::getUniqBrowsers($os_list);
        $uniqRef = StatisticHelper::getUniqBrowsers($ref_list);

        $isShowResult = false;
        $result_data = [];

        if ($request->method() == 'POST') {
            $filter_browser = $request->input('browser');
            $filter_os = $request->input('os');
            $filter_ref = $request->input('ref');
            $filter_page = $request->input('page');

            $result_data = StatisticHelper::getFilteredData($filter_browser, $filter_os, $filter_ref, $filter_page);
        }

        return view('admin/details', [
            'uniq_browsers' => $uniqBrowsers,
            'uniq_os' => $uniqOS,
            'uniq_ref' => $uniqRef,
            'pages' => $pages,
            'is_show_result' => $isShowResult,
            'result_data' => $result_data,
            'menu_config_name' => $this->menu_config_name,
        ]);
    }
}
