<?php declare(strict_types = 1);

namespace Utilitte\Php;

use InvalidArgumentException;
use LogicException;
use OutOfBoundsException;
use Traversable;
use Utilitte\Php\ValueObject\ArraySearchCriteria;
use Utilitte\Php\ValueObject\ArraySynchronized;

class Arrays
{

	/**
	 * @template K
	 * @template V
	 * @param array<K, V> $values
	 * @return array<K, V>
	 */
	public static function remove(array $values, mixed $value, int $limit = -1): array
	{
		foreach ($values as $key => $val) {
			if ($val === $value) {
				unset($values[$key]);
				
				if ($limit !== -1 && (--$limit <= 0)) {
					break;
				}
			}
		}

		return $values;
	}

	public static function allows(array $values, array $keys): array
	{
		$return = [];

		foreach ($keys as $key) {
			$return[$key] = $values[$key] ?? null;
		}

		return $return;
	}

	public static function count(iterable $iterable): int
	{
		return $iterable instanceof Traversable ? iterator_count($iterable) : count($iterable);
	}

	public static function valueToKeyWithBoolValue(iterable $array): array
	{
		$values = [];

		foreach ($array as $value) {
			$values[$value] = true;
		}

		return $values;
	}

	public static function searchBestByArray(array $search, array $in, ArraySearchCriteria $criteria): ?array
	{
		$mustHave = self::combineKeys($criteria->mustHave);
		$mayHave = self::combineKeys($criteria->mayHave);

		$best = null;
		$bestScore = 0;
		foreach ($in as $item) {
			$score = 0;

			foreach ($mustHave as $firstKey => $secondKey) {
				if (!isset($search[$firstKey])) {
					throw new OutOfBoundsException(sprintf('Key %s not exist in 1st argument.', $firstKey));
				}

				if (!isset($item[$secondKey])) {
					continue 2;
				}

				if ($search[$firstKey] !== $item[$secondKey]) {
					continue 2;
				}
			}

			foreach ($mayHave as $firstKey => $secondKey) {
				if (!isset($search[$firstKey])) {
					throw new OutOfBoundsException(sprintf('Key %s not exist in 1st argument.', $firstKey));
				}

				if (!isset($item[$secondKey])) {
					continue;
				}

				if ($search[$firstKey] === $item[$secondKey]) {
					$score++;
				}
			}

			if ($score > $bestScore) {
				$bestScore = $score;
				$best = $item;
			} else if ($best === null && $mustHave) {
				$best = $item;
			}

		}

		return $best;
	}

	public static function searchBy(array $possibilities, array $keyValues): ?array
	{
		foreach ($possibilities as $possibility) {
			foreach ($keyValues as $key => $value) {
				if (!isset($possibility[$key]) || $possibility[$key] !== $value) {
					continue 2;
				}
			}

			return $possibility;
		}

		return null;
	}

	public static function compare(array $first, array $second, array $keys, bool $throwOnInvalidIndex = true): bool
	{
		foreach ($keys as $firstKey => $secondKey) {
			if (is_numeric($firstKey)) {
				$firstKey = $secondKey;
			}

			if (!isset($first[$firstKey])) {
				if ($throwOnInvalidIndex) {
					throw new OutOfBoundsException(sprintf('Key %s not exist in 1st argument.', $firstKey));
				}

				return false;
			}

			if (!isset($second[$secondKey])) {
				if ($throwOnInvalidIndex) {
					throw new OutOfBoundsException(sprintf('Key %s not exist in 2nd argument.', $secondKey));
				}

				return false;
			}

			if ($first[$firstKey] !== $second[$secondKey]) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @throws OutOfBoundsException
	 */
	public static function first(array $array): mixed
	{
		if (!count($array)) {
			throw new OutOfBoundsException('Undefined first key in array.');
		}

		return reset($array);
	}

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
	 * @param mixed[] $values
	 * @return mixed[]
	 */
	public static function castValueToType(array $values, string $type): array
	{
		return array_map(function ($value) use ($type) {
			settype($value, $type);

			return $value;
		}, $values);
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

					break;
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

	public static function removeByIndex(array $source, $value): array
	{
		$index = array_search($source, $value, true);
		if ($index !== false) {
			unset($source[$index]);
		}

		return $source;
	}

	public static function getByPosition(array $array, int|array $positions): mixed
	{
		if (is_array($positions)) {
			$position = array_shift($positions);
		} else {
			$position = $positions;
			$positions = [];
		}

		$i = 0;
		foreach ($array as $value) {
			if ($i === $position) {
				if ($positions) {
					if (!is_array($value)) {
						return null;
					}

					return self::getByPosition($value, $positions);
				}

				return $value;
			}
			$i++;
		}

		return null;
	}

	public static function every(iterable $array, callable $callback, bool $returnIfEmpty = true): bool
	{
		$empty = true;
		foreach ($array as $value) {
			$empty = false;

			if (!$callback($value)) {
				return false;
			}
		}

		if ($empty) {
			return $returnIfEmpty;
		}

		return true;
	}

	public static function some(iterable $array, callable $callback, bool $returnIfEmpty = false): bool
	{
		$empty = true;
		foreach ($array as $value) {
			$empty = false;

			if ($callback($value)) {
				return true;
			}
		}

		if ($empty) {
			return $returnIfEmpty;
		}

		return false;
	}

	/**
	 * @template T
	 * @param T[] $items
	 * @return T[]
	 */
	public static function shuffle(array $items): array
	{
		shuffle($items);

		return $items;
	}

	/**
	 * @template T
	 * @param T[] $items
	 * @return T|null
	 */
	public static function randomOne(array $items): mixed
	{
		if (!$items) {
			return null;
		}

		return $items[array_rand($items)];
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

	private static function combineKeys(array $keys): array
	{
		$searchBy = [];
		foreach ($keys as $firstKey => $secondKey) {
			if (is_numeric($firstKey)) {
				$searchBy[$secondKey] = $secondKey;
			} else {
				$searchBy[$firstKey] = $secondKey;
			}
		}

		return $searchBy;
	}

}
