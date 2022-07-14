<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class Numbers
{

	public static function minMax(int $value, int $min, int $max): int
	{
		return min(max($value, $min), $max);
	}

}
