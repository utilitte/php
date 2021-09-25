<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\Deprecated;
use Utilitte\Php\Numbers\NumberFormatter;

final class Numbers
{

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
