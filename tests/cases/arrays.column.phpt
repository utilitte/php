<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Arrays;

require __DIR__ . '/../bootstrap.php';

Assert::same([1 => 'foo', 2 => 'bar'],
	Arrays::column([['id' => 1, 'name' => 'foo'], ['id' => 2, 'name' => 'bar']], 'name', 'id')
);
