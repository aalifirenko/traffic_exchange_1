<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redis;
use Request;
use Config;
use Closure;

class UpdateStatistic
{
    const VISIT_PREFIX = 'visit';
    const BASE = "stat:page:";
    const SUMMARY = "summary";
    const UNDEFINED = "undefined";
    const BROWSER = ":browser:";
    const OS = ":os:";
    const GEO = ":geo:";
    const REF = ":ref:";
    const IP = ":ip";
    const DATETIME_IP = ":datetime_ip";
    const DATETIME_SESSION = ":datetime_session";
    const HIT = ":hit";
    const SESSION = ":session";
    private $uhash; /* A visit unique hash value */
    private $agent;
    private $user_ip;
    private $current_datetime;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $page_name = $request->route()->getName();
        $this->agent = get_browser();
        $this->user_ip = Request::ip();
        $this->current_datetime = date('Y-m-d H:i:s');

        $this->insertBrowser($page_name);
        $this->insertOs($page_name);
        $this->insertGeo($page_name);
        $this->insertRef($page_name);
        $this->insertSummaryReportData();

        return $next($request);
    }

    private function getAssuredUniqHash($key)
    {
        $asHash = uniqid(rand(1,10),true).time();
        if(Redis::sismember($key, $asHash)) {
            $this->getAssuredUniqHash($key);
        } else {
            return $asHash;
        }
    }

    private function insertSummaryReportData()
    {
        $this->insertBrowser(self::SUMMARY);
        $this->insertOs(self::SUMMARY);
        $this->insertGeo(self::SUMMARY);
        $this->insertRef(self::SUMMARY);
    }

    private function insertBrowser($page_id)
    {
        $browserSet = self::BASE.$page_id.self::BROWSER.$this->agent->browser;
        Redis::sadd($browserSet.self::IP, $this->user_ip);
        Redis::sadd($browserSet.self::DATETIME_IP, $this->current_datetime . '/' . $this->user_ip);
        Redis::sadd($browserSet.self::DATETIME_SESSION, $this->current_datetime . '/' . $this->helperGetCurrentCookieId());
        Redis::sadd($browserSet.self::HIT, $this->getAssuredUniqHash($browserSet.self::HIT));
        Redis::sadd($browserSet.self::SESSION, $this->helperGetCurrentCookieId());
    }

    private function insertOS($page_id)
    {
        $OsSet = self::BASE.$page_id.self::OS.$this->agent->platform;
        Redis::sadd($OsSet.self::IP, $this->user_ip);
        Redis::sadd($OsSet.self::DATETIME_IP, $this->current_datetime . '/' . $this->user_ip);
        Redis::sadd($OsSet.self::DATETIME_SESSION, $this->current_datetime . '/' . $this->helperGetCurrentCookieId());
        Redis::sadd($OsSet.self::HIT, $this->getAssuredUniqHash($OsSet.self::HIT));
        Redis::sadd($OsSet.self::SESSION, $this->helperGetCurrentCookieId());
    }

    private function insertRef($page_id)
    {
        if(empty(Request::server('HTTP_REFERER'))) {
            $parsedUrl = [];
            $parsedUrl['host'] = self::UNDEFINED;
        } else {
            $parsedUrl= parse_url(Request::server('HTTP_REFERER'));
        }
        $RefSet = self::BASE.$page_id.self::REF.$parsedUrl['host'];
        Redis::sadd($RefSet.self::IP, $this->user_ip);
        Redis::sadd($RefSet.self::DATETIME_IP, $this->current_datetime . '/' . $this->user_ip);
        Redis::sadd($RefSet.self::DATETIME_SESSION, $this->current_datetime . '/' . $this->helperGetCurrentCookieId());
        Redis::sadd($RefSet.self::HIT, $this->getAssuredUniqHash($RefSet.self::HIT));
        Redis::sadd($RefSet.self::SESSION, $this->helperGetCurrentCookieId());
    }

    private function insertGeo($page_id)
    {
        $GeoSet = self::BASE.$page_id.self::GEO.$this->helperGetGeoData();
        Redis::sadd($GeoSet.self::IP, $this->user_ip);
        Redis::sadd($GeoSet.self::DATETIME_IP, $this->current_datetime . '/' . $this->user_ip);
        Redis::sadd($GeoSet.self::DATETIME_SESSION, $this->current_datetime . '/' . $this->helperGetCurrentCookieId());
        Redis::sadd($GeoSet.self::HIT, $this->getAssuredUniqHash($GeoSet.self::HIT));
        Redis::sadd($GeoSet.self::SESSION, $this->helperGetCurrentCookieId());
    }

    private function helperGetCurrentCookieId()
    {
        $currentCookiesData = Request::cookie();
        if(empty($currentCookiesData)) {
            $currentSessionHash = self::UNDEFINED;
        } else {
            $currentSessionHash = $currentCookiesData['laravel_session'];
        }
        return $currentSessionHash;
    }

    private function helperGetGeoData()
    {
        $ipValue    = trim(Request::ip());

        /* Заглушка для тестирования на локалки, если ip localhost, то ставим выдуманный внешний ip */
        if ($ipValue == '127.0.0.1') {
            $ipValue = '94.137.60.15';
        }

        $result     = geoip($ipValue);
        $clientData = isset($result['attributes']) ? $result['attributes'] : false;

        $geotag = '';
        if ($clientData) {
            $geotag = $clientData["iso_code"] . '|' . $clientData["city"] . '|' . $clientData["state"];
        }

        return $geotag;
    }
}
