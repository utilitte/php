<?php declare(strict_types = 1);

namespace Utilitte\Php\Strict;

final class Strict
{

	/**
	 * @template T
	 * @param class-string<T> $className
	 * @return T
	 */
	public static function instanceOf(mixed $object, string $className): object
	{
		assert($object instanceof $className);

		return $object;
	}

}
