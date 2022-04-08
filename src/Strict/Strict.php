<?php declare(strict_types = 1);

namespace Utilitte\Php\Strict;

use JetBrains\PhpStorm\Deprecated;

#[Deprecated]
final class Strict
{

	/**
	 * @template T of object
	 * @param class-string<T> $className
	 * @return T
	 */
	#[Deprecated]
	public static function instanceOf(mixed $object, string $className): object
	{
		assert($object instanceof $className);

		return $object;
	}

}
