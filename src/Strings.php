<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class Strings
{

	/**
	 * @return array{string|null, string}
	 */
	public static function splitByNeedle(string $haystack, string $needle): array
	{
		return self::splitByPositionFalseable($haystack, strpos($haystack, $needle), strlen($needle));
	}

	public static function joinWith(string $join, string|null ... $arguments): string
	{
		return implode($join, array_filter($arguments));
	}

	/**
	 * @return array{string, string}
	 */
	public static function splitByPosition(string $haystack, int $pos, int $length = 1): array
	{
		return [
			substr($haystack, 0, $pos),
			substr($haystack, $pos + $length),
		];
	}

	/**
	 * @return array{string|null, string}
	 */
	public static function splitByPositionFalseable(string $haystack, int|false $pos, int $length = 1): array
	{
		if ($pos === false) {
			return [null, $haystack];
		}

		return self::splitByPosition($haystack, $pos, $length);
	}

	public static function append(?string $string, string $append): ?string
	{
		if (!$string) {
			return $string;
		}

		return $string . $append;
	}

	public static function prepend(string $prepend, ?string $string): ?string
	{
		if (!$string) {
			return $string;
		}

		return $prepend . $string;
	}

}
