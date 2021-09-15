<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class LazyString
{

	/** @var callable */
	private $callback;

	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function __toString(): string
	{
		return (string) ($this->callback)();
	}

}
