<?php declare(strict_types = 1);

namespace Utilitte\Php;

use InvalidArgumentException;
use JetBrains\PhpStorm\Deprecated;
use Utilitte\Php\Numbers\NumberFormatter;

final class Numbers
{

	public static function convertToFloat(string|int|float $number): float
	{
		if (!is_numeric($number)) {
			throw new InvalidArgumentException('Given argument is not a number.');
		}

		$number = (float) $number;

		if (is_nan($number) || is_infinite($number)) {
			throw new InvalidArgumentException('Given argument is not a number.');
		}

		return $number;
	}

	public static function minMax(int $value, int $min, int $max): int
	{
		return min(max($value, $min), $max);
	}

	#[Deprecated]
	public static function bytes(float $bytes, int $precision = 2, bool $withSpace = true): string
	{
		return NumberFormatter::formatBytes($bytes, $precision);
	}

	#[Deprecated]
	public static function formatShort(int $value, int $precision = 1): string
	{
		return NumberFormatter::formatShort($value, $precision);
	}

}
