<?php declare(strict_types = 1);

namespace Utilitte\Php\ValueObject;

final class ArraySearchCriteria
{

	public function __construct(
		public array $mayHave = [],
		public array $mustHave = [],
	)
	{
	}

}
