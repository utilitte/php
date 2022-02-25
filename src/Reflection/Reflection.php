<?php declare(strict_types = 1);

namespace Utilitte\Php\Reflection;

use ReflectionClass;
use ReflectionMethod;

final class Reflection
{

	/**
	 * @template T of object
	 * @param class-string<T> $name
	 * @return T|null
	 */
	public static function getAttributeObject(ReflectionMethod|ReflectionClass $reflection, string $name): ?object
	{
		$attribute = $reflection->getAttributes($name)[0] ?? null;

		if (!$attribute) {
			return null;
		}

		return $attribute->newInstance();
	}

}
