<?php
namespace App\Helpers;

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
}