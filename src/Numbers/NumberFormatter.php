<?php declare(strict_types = 1);

namespace Utilitte\Php\Numbers;

use LogicException;

final class NumberFormatter
{

	public static function formatBytes(int|float $number, ?int $decimals = null, bool $fixed = false): string
	{
		static $end = 'PB';
		static $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];

		$unit = 'B';
		foreach ($units as $unit) {
			if (abs($number) < 1024 || $unit === $end) {
				break;
			}

			$number /= 1024;
		}

		return self::formatNumber($number, $decimals, $fixed). $unit;
	}

	public static function formatShort(int|float $number, ?int $decimals = null, bool $fixed = false): string
	{
		static $formatters = [
			'' => 1_000,
			'K' => 1_000_000,
			'M' => 1_000_000_000,
			'B' => 1_000_000_000_000,
			'T' => null,
		];

		$divider = 1;
		foreach ($formatters as $str => $limit) {
			if ($limit === null || $number < $limit) {
				return self::formatNumber($number / $divider, $decimals, $fixed) . $str;
			}

			$divider = $limit;
		}

		throw new LogicException('Unexpected error.');
	}

	public static function formatPercentage(
		string|int|float|null $number,
		int $decimals = 2,
		bool $sign = true,
		bool $fixed = true,
	): ?string
	{
		if ($number === null || is_string($number) && !is_numeric($number)) {
			return null;
		}

		$value = self::formatNumber($number, $decimals, $fixed);

		if ($value === null) {
			return null;
		}

		return ($sign && $number > 0 ? '+' : '') . $value . '%';
	}

	public static function formatNumber(string|int|float|null $number, ?int $decimals = null, bool $fixed = false): ?string
	{
		if (!is_numeric($number)) {
			return null;
		}

		$number = (float) $number;

		if (is_nan($number) || is_infinite($number)) {
			return null;
		}

		if ($decimals === null) {
			$decimals = 2;

			if ($number < 0.01) {
				$decimals = 6;
			} elseif ($number < 0.1) {
				$decimals = 5;
			} elseif ($number < 1) {
				$decimals = 4;
			} elseif ($number < 10) {
				$decimals = 3;
			}
		}

		$number = number_format($number, $decimals);

		if (!$fixed) {
			$number = self::removeZerosAfterDot($number);
		}

		return $number;
	}

	public static function removeZerosAfterDot(string $number): string
	{
		return rtrim(rtrim($number, '0'), '.');
	}

}
