<?php declare(strict_types = 1);

namespace Utilitte\Php\Reflection;

use Generator;
use ReflectionClass;
use ReflectionMethod;

final class Reflection
{

	/**
	 * @template T of object
	 * @template TRef of object
	 * @param ReflectionClass<TRef>|ReflectionMethod $reflection
	 * @param class-string<T> $className
	 * @return T|null
	 */
	public static function getAttribute(ReflectionMethod|ReflectionClass $reflection, string $className): ?object
	{
		$attribute = $reflection->getAttributes($className)[0] ?? null;

		return $attribute?->newInstance();
	}

	/**
	 * @template T of object
	 * @template TRef of object
	 * @param ReflectionClass<TRef>|ReflectionMethod $reflection
	 * @param class-string<T> $className
	 * @return Generator<T>
	 */
	public static function getAttributes(ReflectionMethod|ReflectionClass $reflection, string $className): Generator
	{
		foreach ($reflection->getAttributes($className) as $attribute) {
			yield $attribute->newInstance();
		}
	}

}
