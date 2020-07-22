<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Arrays;

require __DIR__ . '/../bootstrap.php';

$diff = Arrays::synchronize(
	['foo', 'remove'],
	['foo', 'add']
);

Assert::same(['add'], array_values($diff->getAdded()));
Assert::same(['remove'], array_values($diff->getRemoved()));
Assert::same(['foo', 'add'], array_values($diff->getResult()));
