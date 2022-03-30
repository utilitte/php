<?php declare(strict_types = 1);

namespace Utilitte\Php\Numbers;

use InvalidArgumentException;
use LogicException;
use Utilitte\Php\Numbers;

final class NumberFormatter
{

	public static function formatBytes(string|int|float $number, ?int $decimals = null, bool $fixed = true): string
	{
		static $end = 'PB';
		static $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];

		$number = Numbers::convertToFloat($number);

		$unit = 'B';
		foreach ($units as $unit) {
			if (abs($number) < 1024 || $unit === $end) {
				break;
			}

			$number /= 1024;
		}

		return self::formatNumber($number, $decimals, $fixed) . $unit;
	}

	public static function formatShort(string|int|float $number, ?int $decimals = null, bool $fixed = true): string
	{
		static $formatters = [
			'' => 1_000,
			'K' => 1_000_000,
			'M' => 1_000_000_000,
			'B' => 1_000_000_000_000,
			'T' => null,
		];

		$number = Numbers::convertToFloat($number);
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
		string|int|float $number,
		?int $decimals = null,
		bool $fixed = true,
		bool $sign = false,
	): string
	{
		return self::formatNumber($number, $decimals, $fixed, $sign) . '%';
	}

	public static function formatNumber(
		string|int|float|null $number,
		?int $decimals = null,
		bool $fixed = true,
		bool $sign = false,
	): string
	{
		$number = Numbers::convertToFloat($number);

		if ($decimals === null) {
			if ($fixed === true) {
				$decimals = 0;
			} elseif ($number < 0.01) {
				$decimals = 5;
			} elseif ($number < 0.1) {
				$decimals = 4;
			} elseif ($number < 1) {
				$decimals = 3;
			} else {
				$decimals = 2;
			}
		}

		$number = number_format($number, $decimals);

		if (!$fixed) {
			$number = self::removeZerosAfterDot($number);
		}

		return ($sign && $number > 0 ? '+' : '') . $number;
	}

	public static function removeZerosAfterDot(string $number): string
	{
		$return = rtrim(rtrim($number, '0'), '.');
		
		return $return === '' ? '0' : $return;
	}

}
