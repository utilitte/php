<?php declare(strict_types = 1);

namespace Utilitte\Php\Reflection;

use Generator;
use JetBrains\PhpStorm\Deprecated;
use ReflectionClass;
use ReflectionMethod;

final class Reflection
{

	/**
	 * @template T of object
	 * @param class-string<T> $name
	 * @return T|null
	 */
	#[Deprecated]
	public static function getAttributeObject(ReflectionMethod|ReflectionClass $reflection, string $name): ?object
	{
		return self::getAttribute($reflection, $name);
	}

	/**
	 * @template T of object
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
