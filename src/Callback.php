<?php declare(strict_types = 1);

namespace Utilitte\Php;

class Callback
{

	/**
	 * @param callable[] $callbacks
	 */
	public static function applyCallbacks(array $callbacks, ...$args): void
	{
		foreach ($callbacks as $callback) {
			$callback(...$args);
		}
	}

}
