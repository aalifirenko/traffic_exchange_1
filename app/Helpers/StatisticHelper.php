<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Redis;
use Request;
use Config;
use Closure;

class StatisticHelper
{
	public static function getDatetimeCount($collection, $pattern)
	{
		$count = 0;
		$start_date = '';
		$end_date = '';
		$current_date = date('Y-m-d H:i:s');
		$counted_uniq = [];

		foreach ($collection as $key => $param) {
			$paramArr = explode('/', $param);
			$date = $paramArr[0];
			$uniq = $paramArr[1];
			switch ($pattern) {
				case '24h':
					$start_date = date('Y-m-d H:i:s', strtotime('-24 hours'));
					$end_date = $current_date;
					break;
				case '7d':
					$start_date = date('Y-m-d H:i:s', strtotime('-7 days'));
					$end_date = $current_date;
					break;
				case '31d':
					$start_date = date('Y-m-d H:i:s', strtotime('-31 days'));
					$end_date = $current_date;
					break;
			}

			if ($date >= $start_date && $date <= $end_date && !isset($counted_uniq[$uniq])) {
				$count++;
				$counted_uniq[$uniq] = true;
			}
		}

		return $count;
	}

	public static function getUniqBrowsers($browsers)
	{
		$data = [];

		foreach ($browsers as $browser) {
			$browserArrayData = explode(":", $browser);
			array_push($data, $browserArrayData[4]);
		}

		return $data;
	}

	public static function getUniqOS($os_list)
	{
		$data = [];

		foreach ($os_list as $os) {
			$osArrayData = explode(":", $os);
			array_push($data, $osArrayData[4]);
		}

		return $data;
	}

	public static function getUniqRef($ref_list)
	{
		$data = [];

		foreach ($ref_list as $ref) {
			$refArrayData = explode(":", $ref);
			array_push($data, $refArrayData[4]);
		}

		return $data;
	}

	public static function getFilteredData($browser, $os, $ref, $page)
	{
		$data = [];

		return $data;
	}
}