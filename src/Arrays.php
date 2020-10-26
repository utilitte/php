<?php declare(strict_types = 1);

namespace Utilitte\Php;

use InvalidArgumentException;
use LogicException;
use Traversable;
use Utilitte\Php\ValueObject\ArraySynchronized;

class Arrays
{

	/**
	 * @param mixed[] $defaults
	 * @param mixed[] $array
	 * @return mixed[]
	 */
	public static function defaults(array $defaults, iterable $array, bool $soft = false): array
	{
		foreach ($array as $key => $value) {
			if (!array_key_exists($key, $defaults)) {
				if (!$soft) {
					throw new LogicException(
						sprintf('Key %s is not allowed in array', $key)
					);
				}

				continue;
			}

			$defaults[$key] = $value;
		}

		return $defaults;
	}

	/**
	 * @param mixed[] $array
	 * @return mixed
	 */
	public static function firstValue(array $array)
	{
		$key = array_key_first($array);

		if ($key === null) {
			throw new InvalidArgumentException('Given array is empty');
		}

		return $array[$key];
	}

	/**
	 * @param mixed[] $previous
	 * @param mixed[] $current
	 */
	public static function synchronize(
		iterable $previous,
		iterable $current,
		?callable $comparator = null
	): ArraySynchronized
	{
		$comparator ??= [self::class, 'strictComparator'];

		$added = self::iterableToArray($current);
		$removed = self::iterableToArray($previous);
		$result = $added;

		foreach ($removed as $key => $value) {
			foreach ($added as $key1 => $value1) {
				if ($comparator($value, $value1)) {
					unset($removed[$key]);
					unset($added[$key1]);
				}
			}
		}

		return new ArraySynchronized($added, $removed, $result);
	}

	/**
	 * @param mixed[] $iterable
	 * @return mixed[]
	 */
	public static function iterableToArray(iterable $iterable): array
	{
		return $iterable instanceof Traversable ? iterator_to_array($iterable) : (array) $iterable;
	}

	/**
	 * @param mixed[] $values
	 * @param string|int $key
	 * @param string|int $value
	 * @return mixed[]
	 */
	public static function twoDimensionArrayToAssociativeArray(array $values, $key, $value): array
	{
		$return = [];

		foreach ($values as $itemKey => $item) {
			if (!array_key_exists($key, $item)) {
				throw new InvalidArgumentException(
					sprintf('Key "key" %s not exists in array[%s]', (string) $key, (string) $itemKey)
				);
			}

			if (!array_key_exists($value, $item)) {
				throw new InvalidArgumentException(
					sprintf('Key "value" %s not exists in array[%s]', (string) $value, (string) $itemKey)
				);
			}

			$return[$item[$key]] = $item[$value];
		}

		return $return;
	}

	/**
	 * @param mixed $first
	 * @param mixed $second
	 * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedMethod
	 */
	private static function strictComparator($first, $second): bool
	{
		return $first === $second;
	}

}
