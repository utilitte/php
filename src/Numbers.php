<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class Numbers
{

	public static function minMax(int $value, int $min, int $max): int
	{
		return min(max($value, $min), $max);
	}

	public static function bytes(float $bytes, int $precision = 2, bool $withSpace = true): string
	{
		$bytes = round($bytes);
		$units = ['B', 'kB', 'MB', 'GB', 'TB', $end = 'PB'];

		foreach ($units as $unit) {
			if (abs($bytes) < 1024 || $unit === $end) {
				break;
			}

			$bytes /= 1024;
		}

		return round($bytes, $precision) . ($withSpace ? ' ' : '') . $unit;
	}

}
