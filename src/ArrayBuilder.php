<?php declare(strict_types = 1);

namespace Utilitte\Php;

// phpcs:ignoreFile -- cs bug

final class ArrayBuilder
{

	/** @var mixed[] */
	private array $values = [];

	public static function create(): self
	{
		return new self();
	}

	/**
	 * @param mixed[] $values
	 */
	public function setValues(array $values): self
	{
		$this->values = $values;

		return $this;
	}

	/**
	 * @param mixed $values
	 */
	public function addSkipIfEmpty(string $key, $values): self
	{
		if (!empty($values)) {
			$this->values[$key] = $values;
		}

		return $this;
	}

	/**
	 * @param mixed $values
	 */
	public function addSkipIf(string $key, $values, bool $skip): self
	{
		if (!$skip) {
			$this->values[$key] = $values;
		}

		return $this;
	}

	/**
	 * @param mixed $values
	 */
	public function appendSkipIf($values, bool $skip): self
	{
		if (!$skip) {
			$this->values[] = $values;
		}

		return $this;
	}

	/**
	 * @param mixed $values
	 */
	public function append($values): self
	{
		$this->values[] = $values;

		return $this;
	}

	/**
	 * @param mixed $values
	 */
	public function add(string $key, $values): self
	{
		$this->values[$key] = $values;

		return $this;
	}

	/**
	 * @return mixed[]
	 */
	public function getResult(): array
	{
		return $this->values;
	}

}
