<?php declare(strict_types = 1);

namespace Utilitte\Php;

use Nette\Utils\Json;
use Nette\Utils\Strings;

final class Html
{

	/**
	 * Converts dataTrigger => data-trigger, DataTrigger => data-trigger
	 */
	public static function camel2Dashed(string $string): string
	{
		return strtolower(preg_replace('#([a-zA-Z])(?=[A-Z])#', '$1-', Strings::firstLower($string)));
	}

	public static function attribute(string $name, mixed $value): string
	{
		return sprintf('%s="%s"', $name, htmlspecialchars(self::convertToString($value), ENT_QUOTES));
	}

	private static function convertToString(mixed $value): string
	{
		if (is_array($value)) {
			return Json::encode($value);
		}

		if ($value === false) {
			return '0';
		}

		return (string) $value;
	}

}
