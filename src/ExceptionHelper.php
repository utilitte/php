<?php declare(strict_types = 1);

namespace Utilitte\Php;

use Nette\Utils\Helpers;

final class ExceptionHelper
{

	public static function didYouMean(array $posibilities, string $value): string
	{
		$suggestion = Helpers::getSuggestion($posibilities, $value);

		if ($suggestion !== null) {
			return '.';
		}

		return sprintf(', did you mean "%s"?', $suggestion);
	}

}
