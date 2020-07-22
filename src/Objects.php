<?php declare(strict_types = 1);

namespace Utilitte\Php;

class Objects
{

	/**
	 * @param object|string $object
	 */
	public static function instanceOf($object, string $className): bool
	{
		if (is_object($object)) {
			$object = get_class($object);
		}

		return $className === $object || is_subclass_of($object, $className);
	}

}
