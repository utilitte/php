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

	public static function formatShort(int $value, int $precision = 1): string
	{
		// 1_000
		if ($value < 1000) {
			return self::removeUnnecessaryDotsZeros($value, $precision);
		} elseif ($value < 1000000) {
			// 1_000_000
			return self::removeUnnecessaryDotsZeros($value / 1000, $precision) . 'K';
		} elseif ($value < 1000000000) {
			// 1_000_000_000
			return self::removeUnnecessaryDotsZeros($value / 1000000, $precision) . 'M';
		} elseif ($value < 1000000000000) {
			// 1_000_000_000_000
			return self::removeUnnecessaryDotsZeros($value / 1000000000, $precision) . 'B';
		}

		return self::removeUnnecessaryDotsZeros($value / 1000000000000, $precision) . 'T';
	}

	private static function removeUnnecessaryDotsZeros(float $value, int $precision): string
	{
		$value = rtrim(number_format($value, $precision), '0.');

		return $value === '' ? '0' : $value;
	}

}
