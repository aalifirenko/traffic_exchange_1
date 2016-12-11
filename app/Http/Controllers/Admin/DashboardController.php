<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
}
