<?php declare(strict_types = 1);

namespace Utilitte\Php;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

final class LazyIterable implements IteratorAggregate, ArrayAccess
{

	/** @var callable */
	private $callback;

	/** @var mixed[] */
	private array $array;

	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function toArray(): array
	{
		if (!isset($this->array)) {
			$this->array = Arrays::iterableToArray(($this->callback)());
		}

		return $this->array;
	}

	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->toArray());
	}

	public function offsetExists(mixed $offset): bool
	{
		return isset($this->toArray()[$offset]) || array_key_exists($offset, $this->array);
	}

	public function offsetGet(mixed $offset): mixed
	{
		return $this->toArray()[$offset];
	}

	public function offsetSet(mixed $offset, mixed $value): void
	{
		$this->toArray();

		$this->array[$offset] = $value;
	}

	public function offsetUnset(mixed $offset): void
	{
		$this->toArray();

		unset($this->array[$offset]);
	}

}
