<?php declare(strict_types = 1);

namespace Utilitte\Php;

use DomainException;
use Nette\Utils\Floats;

final class Numbers
{

	public static function toInt(int|float|string $number, bool $strict = true): int
	{
		if (is_int($number)) {
			return $number;
		}

		if (is_float($number)) {
			if (!$strict) {
				return (int) $number;
			}

			if (!Floats::isInteger($number)) {
				throw new DomainException(sprintf('Number %s is not strict int.', $number));
			}

			return (int) $number;
		}

		if (!is_numeric($number)) {
			throw new DomainException('Given value is not a number.');
		}

		if (str_contains($number, '.')) {
			return self::toInt((float) $number, $strict);
		}

		return (int) $number;
	}

	public static function toFloat(int|float|string $number, bool $strict = true): float
	{
		if (is_float($number)) {
			return $number;
		}

		if (is_int($number)) {
			return (float) $number;
		}

		if (!is_numeric($number)) {
			throw new DomainException('Given value is not a number.');
		}

		return (float) $number;
	}

	public static function minMax(int $value, int $min, int $max): int
	{
		return min(max($value, $min), $max);
	}

}
