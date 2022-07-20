<?php declare(strict_types = 1);

namespace Utilitte\Php\Exception;

use Nette\Utils\Helpers;

final class ExceptionSuggestion
{

	/**
	 * @param mixed[] $possibilities
	 */
	public static function didYouMean(array $possibilities, string|int $value): string
	{
		if (is_int($value)) {
			return '.';
		}

		$suggestion = Helpers::getSuggestion($possibilities, $value);

		if (!$suggestion) {
			return '.';
		}

		return sprintf(', did you mean "%s"?', $suggestion);
	}

}
