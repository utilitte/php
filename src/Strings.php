<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\ArrayShape;

final class Strings
{

	#[ArrayShape('string', 'string')]
	public static function splitByPosition(string $haystack, int $pos): array
	{
		return [
			substr($haystack, 0, $pos),
			substr($haystack, $pos + 1),
		];
	}

	#[ArrayShape('string|null', 'string')]
	public static function splitByPositionFalseable(string $haystack, int|false $pos): array
	{
		if ($pos === false) {
			return [null, $haystack];
		}

		return self::splitByPosition($haystack, $pos);
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
