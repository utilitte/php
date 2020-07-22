<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Arrays;

require __DIR__ . '/../bootstrap.php';

$values = Arrays::defaults(
	['key' => 'foo', 'key2' => 'foo'],
	['key' => 'bar']
);

Assert::same(['key' => 'bar', 'key2' => 'foo'], $values);

Assert::exception(function (): void {
	Arrays::defaults(
		['key' => 'foo', 'key2' => 'foo'],
		['key' => 'bar', 'key3' => 'key']
	);
}, LogicException::class);
