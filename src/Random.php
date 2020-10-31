<?php declare(strict_types = 1);

namespace Utilitte\Php;

use InvalidArgumentException;

final class Random
{

	public static function chance(int $percentage, bool $strict = true): bool
	{
		if ($percentage <= 0) {
			if ($strict && $percentage < 0) {
				throw new InvalidArgumentException('Percentage must be greater than or equal to 0');
			}

			return false;
		} elseif ($percentage >= 100) {
			if ($strict && $percentage > 100) {
				throw new InvalidArgumentException('Percentage must be less than or equal to 100');
			}

			return true;
		}

		return mt_rand(1, 100) <= $percentage;
	}

}
