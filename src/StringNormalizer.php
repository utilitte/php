<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class StringNormalizer
{

	/**
	 * @var string[]
	 * @copyright https://stackoverflow.com/a/12824140
	 */
	private static array $emojiRegexes = [
		'\x{1F600}-\x{1F64F}', // emoticons,
		'\x{1F300}-\x{1F5FF}', // miscellaneous, pictographs
		'\x{1F680}-\x{1F6FF}', // transport, map symbols
		'\x{2600}-\x{26FF}', // miscellaneous
		'\x{2700}-\x{27BF}', // dingbats
	];

	public static function normalizeSpaces(string $str): string
	{
		return preg_replace('# {2,}#', ' ', trim($str));
	}

	public static function normalizeWhitespaces(string $str): string
	{
		$str = preg_replace('#[\r\n]+#', ' ', trim($str));

		return preg_replace('#\s{2,}#', ' ', $str);
	}

	public static function normalizeEmoji(string $str): string
	{
		return trim(preg_replace(sprintf('#\s*[%s]+\s*#u', implode('', self::$emojiRegexes)), ' ', $str), ' ');
	}

}
