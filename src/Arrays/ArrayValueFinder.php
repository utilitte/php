<?php declare(strict_types = 1);

namespace Utilitte\Php\Arrays;

final class ArrayValueFinder
{

	/** @var array<string|int, bool> */
	private array $map = [];

	public function __construct(iterable $array)
	{
		foreach ($array as $value) {
			$this->map[$value] = true;
		}
	}

	public static function from(iterable $array): self
	{
		return new self($array);
	}

	public function has(string|int $value): bool
	{
		return isset($this->map[$value]);
	}

}
