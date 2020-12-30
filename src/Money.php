<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class Money
{

	public static function formatShort(int $value, int $precision = 1): string
	{
		// 1_000
		if ($value < 1000) {
			return self::formatMoney($value, $precision);
		} elseif ($value < 1000000) {
		// 1_000_000
			return self::formatMoney($value / 1000, $precision) . 'K';
		} elseif ($value < 1000000000) {
		// 1_000_000_000
			return self::formatMoney($value / 1000000, $precision) . 'M';
		} elseif ($value < 1000000000000) {
		// 1_000_000_000_000
			return self::formatMoney($value / 1000000000, $precision) . 'B';
		}

		return self::formatMoney($value / 1000000000000, $precision) . 'T';
	}

	private static function formatMoney(float $value, int $precision): string
	{
		return rtrim(number_format($value, $precision), '0.');
	}

}
