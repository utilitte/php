<?php declare(strict_types = 1);

namespace Utilitte\Php;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

/**
 * @template T
 * @implements ArrayAccess<T>
 */
final class LazyArrayAccess implements ArrayAccess
{

	/** @var callable(): T */
	private $callback;

	/** @var T[] */
	private array $cache;

	/**
	 * @param callable(): T
	 */
	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	/**
	 * @return T[]|ArrayAccess<T>
	 */
	public function getSource(): array|ArrayAccess
	{
		return ($this->callback)();
	}

	/**
	 * @return T[]|ArrayAccess<T>
	 */
	private function getArrayAccess(): array|ArrayAccess
	{
		if (!isset($this->arrayAccess)) {
			$result = ($this->callback)();
			if (!$result instanceof ArrayAccess && !is_array($result)) {
				$result = Arrays::iterableToArray($result);
			}

			$this->arrayAccess = $result;
		}

		return $this->arrayAccess;
	}

	public function offsetExists(mixed $offset): bool
	{
		return isset($this->getArrayAccess()[$offset]) || array_key_exists($offset, $this->array);
	}

	/**
	 * @return T
	 */
	public function offsetGet(mixed $offset): mixed
	{
		return $this->getArrayAccess()[$offset];
	}

	/**
	 * @param T $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void
	{
		$this->getArrayAccess();

		$this->array[$offset] = $value;
	}

	public function offsetUnset(mixed $offset): void
	{
		$this->getArrayAccess();

		unset($this->array[$offset]);
	}

}
