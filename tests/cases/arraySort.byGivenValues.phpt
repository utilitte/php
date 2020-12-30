<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\ArraySort;

require __DIR__ . '/../bootstrap.php';

Assert::same([
	['id' => 5],
	['id' => 1],
	['id' => 3],
], ArraySort::byGivenValues(
	[5, 1, 3],
	[
		['id' => 1],
		['id' => 3],
		['id' => 5],
	],
	fn (array $value) => $value['id'],
));
