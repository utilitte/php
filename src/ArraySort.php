<?php declare(strict_types = 1);

namespace Utilitte\Php;

final class ArraySort
{

	/**
	 * @param mixed[] $sortBy
	 * @param mixed[] $values
	 * @return mixed[]
	 */
	public static function byGivenValues(array $sortBy, array $values, callable $idGetter): array
	{
		$valuesById = [];

		foreach ($values as $value) {
			$valuesById[$idGetter($value)] = $value;
		}

		$sorted = [];

		foreach ($sortBy as $id) {
			if (isset($valuesById[$id])) {
				$sorted[] = $valuesById[$id];

				unset($valuesById[$id]);
			}
		}

		foreach ($valuesById as $value) {
			$sorted[] = $value;
		}

		return $sorted;
	}

}
