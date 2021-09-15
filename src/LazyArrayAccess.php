<?php declare(strict_types = 1);

namespace Utilitte\Php;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

final class LazyArrayAccess implements ArrayAccess
{

	/** @var callable */
	private $callback;

	private mixed $arrayAccess;

	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function getSource(): mixed
	{
		return ($this->callback)();
	}

	private function getArrayAccess(): mixed
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

	public function offsetGet(mixed $offset): mixed
	{
		return $this->getArrayAccess()[$offset];
	}

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
