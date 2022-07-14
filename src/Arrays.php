<?php declare(strict_types = 1);

namespace Utilitte\Php;

use InvalidArgumentException;
use OutOfBoundsException;
use Traversable;

class Arrays
{

	/**
	 * @template TKey of string|int
	 * @template TValue
	 * @template TResult
	 * @param iterable<TKey, TValue> $values
	 * @param callable(TValue, TKey, iterable<TKey, TValue>): TResult $callback
	 * @return array<TKey, TResult>
	 */
	public static function map(iterable $values, callable $callback): array
	{
		$array = [];

		foreach ($values as $key => $value) {
			$array[$key] = $callback($value, $key, $values);
		}

		return $array;
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @template TResult
	 * @param iterable<TKey, TValue> $values
	 * @param callable(TValue, TKey, iterable<TKey, TValue>): TResult $callback
	 * @return array<int, TResult>
	 */
	public static function mapIgnoreKeys(iterable $values, callable $callback): array
	{
		$array = [];

		foreach ($values as $key => $value) {
			$array[] = $callback($value, $key, $values);
		}

		return $array;
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @param array<TKey, TValue> $values
	 * @return array<TKey, TValue>
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

	/**
	 * @param iterable<mixed> $iterable
	 * @return int
	 */
	public static function count(iterable $iterable): int
	{
		return $iterable instanceof Traversable ? iterator_count($iterable) : count($iterable);
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @param iterable<TKey, TValue> $iterable
	 * @return array<TKey, TValue>
	 */
	public static function toArray(iterable $iterable): array
	{
		return $iterable instanceof Traversable ? iterator_to_array($iterable) : (array) $iterable;
	}

	/**
	 * @template TValue
	 * @param iterable<TValue> $iterable
	 * @return array<int, TValue>
	 */
	public static function toArrayIgnoreKeys(iterable $iterable): array
	{
		return $iterable instanceof Traversable ? iterator_to_array($iterable, false) : array_values((array) $iterable);
	}

	/**
	 * @template TValue
	 * @param TValue[] $array
	 * @return int|string
	 * @throws OutOfBoundsException
	 */
	public static function first(array $array): mixed
	{
		$key = array_key_first($array);

		if ($key === null) {
			throw new OutOfBoundsException('Cannot get first key from empty array.');
		}

		return $key;
	}

	/**
	 * @template TKey of string|int
	 * @param array<TKey, mixed> $array
	 * @return TKey
	 */
	public static function firstValue(array $array): string|int
	{
		$key = array_key_first($array);

		if ($key === null) {
			throw new InvalidArgumentException('Cannot get first value from empty array.');
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
	 * @param mixed[] $values
	 * @return mixed[]
	 */
	public static function column(iterable $values, string|int $value, string|int|null $key = null): array
	{
		$array = [];

		if ($key !== null) {
			foreach ($values as $itemKey => $item) {
				if (!array_key_exists($key, $item)) {
					throw new OutOfBoundsException(
						sprintf('Key "%s" not exists in array[%s].', $key, $itemKey)
					);
				}

				if (!array_key_exists($value, $item)) {
					throw new OutOfBoundsException(
						sprintf('Key "%s" not exists in array[%s].', $value, $itemKey)
					);
				}

				$array[$item[$key]] = $item[$value];
			}

		} else {
			foreach ($values as $itemKey => $item) {
				if (!array_key_exists($value, $item)) {
					throw new OutOfBoundsException(
						sprintf('Key "%s" not exists in array[%s].', $value, $itemKey)
					);
				}

				$array[] = $item[$value];
			}

		}

		return $array;
	}

	/**
	 * @deprecated
	 * @param mixed[] $values
	 * @param string|int $key
	 * @param string|int $value
	 * @return mixed[]
	 */
	public static function twoDimensionArrayToAssociativeArray(array $values, $key, $value): array
	{
		return self::column($values, $value, $key);
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @param iterable<TKey, TValue> $array
	 * @param callable(TValue, TKey): bool $callback
	 */
	public static function every(iterable $array, callable $callback, bool $returnIfEmpty = true): bool
	{
		$empty = true;
		foreach ($array as $key => $value) {
			$empty = false;

			if (!$callback($value, $key)) {
				return false;
			}
		}

		if ($empty) {
			return $returnIfEmpty;
		}

		return true;
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @param iterable<TKey, TValue> $array
	 * @param callable(TValue, TKey): bool $callback
	 */
	public static function some(iterable $array, callable $callback, bool $returnIfEmpty = false): bool
	{
		$empty = true;
		foreach ($array as $key => $value) {
			$empty = false;

			if ($callback($value, $key)) {
				return true;
			}
		}

		if ($empty) {
			return $returnIfEmpty;
		}

		return false;
	}

	/**
	 * @template TKey
	 * @template TValue
	 * @param array<TKey, TValue> $items
	 * @return array<TKey, TValue>
	 */
	public static function shuffle(array $items): array
	{
		shuffle($items);

		return $items;
	}

	/**
	 * @template TValue
	 * @param TValue[] $items
	 * @return TValue|null
	 */
	public static function randomItem(array $items): mixed
	{
		if (!$items) {
			return null;
		}

		return $items[array_rand($items)];
	}

}
