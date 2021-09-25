<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\Deprecated;
use Utilitte\Php\Numbers\NumberFormatter;

#[Deprecated]
final class Money
{

	#[Deprecated]
	public static function formatShort(int $value, int $precision = 1): string
	{
		return NumberFormatter::formatShort($value, $precision);
	}

}
