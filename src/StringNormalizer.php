<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class StringNormalizer
{

	/**
	 * @var string[]
	 */
	private static array $emojiRegexes = [
		// emoticons,
		'\x{1F600}-\x{1F64F}',
		// miscellaneous, pictographs
		'\x{1F300}-\x{1F5FF}',
		// transport, map symbols
		'\x{1F680}-\x{1F6FF}',
		// miscellaneous
		'\x{2600}-\x{26FF}',
		// dingbats
		'\x{2700}-\x{27BF}',
	];

	public static function normalizeSpaces(string $str): string
	{
		return (string) preg_replace('# {2,}#', ' ', trim($str));
	}

	public static function normalizeWhitespaces(string $str): string
	{
		$str = (string) preg_replace('#[\r\n]+#', ' ', trim($str));

		return (string) preg_replace('#\s{2,}#', ' ', $str);
	}

	public static function normalizeEmoji(string $str): string
	{
		return (string) trim(
			(string) preg_replace(sprintf('#\s*[%s]+\s*#u', implode('', self::$emojiRegexes)), ' ', $str),
			' '
		);
	}

}
