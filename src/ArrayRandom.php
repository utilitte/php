<?php declare(strict_types = 1);

namespace Utilitte\Php;

use Countable;
use IteratorAggregate;
use LogicException;

/**
 * @template T
 */
final class ArrayRandom implements IteratorAggregate, Countable
{

	/** @var array<int, string|int> */
	private array $keys = [];

	private int $position = 0;

	private int $count;

	/**
	 * @param array<string|int, T> $items
	 */
	public function __construct(
		private array $items,
		private bool $autoRewind = false,
	)
	{
		$this->count = count($this->items);

		$this->shuffle();
	}

	public function isOk(): bool
	{
		return (bool) $this->count;
	}

	public function hasNext(): bool
	{
		return $this->position !== $this->count;
	}

	/**
	 * @return T
	 */
	public function next(): mixed
	{
		return $this->items[$this->nextKey()];
	}

	public function nextKey(): string|int
	{
		if (!$this->isOk()) {
			throw new LogicException('Given array is empty');
		}

		if ($this->position >= $this->count) {
			if ($this->autoRewind) {
				$this->rewind();
			} else {
				throw new LogicException('Random array has not next element, please check with hasNext().');
			}
		}

		$key = $this->keys[$this->position++];

		return $key;
	}

	public function rewind(): void
	{
		$this->position = 0;
	}

	public function getIterator()
	{
		while ($this->hasNext()) {
			$key = $this->nextKey();
			yield $key => $this->items[$key];
		}
	}

	public function count(): int
	{
		return $this->count;
	}

	private function shuffle(): void
	{
		if (!$this->count) {
			return;
		}

		if ($this->count === 1) {
			$this->keys = [array_key_first($this->items)];

			return;
		}

		$this->keys = array_keys($this->items);
		shuffle($this->keys);
	}

}
