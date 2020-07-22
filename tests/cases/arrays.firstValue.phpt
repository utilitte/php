<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Arrays;

require __DIR__ . '/../bootstrap.php';

Assert::same('foo', Arrays::firstValue(['foo', 'bar']));

Assert::exception(function (): void {
	Arrays::firstValue([]);
}, InvalidArgumentException::class);
