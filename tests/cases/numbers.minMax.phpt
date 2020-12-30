<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Numbers;

require __DIR__ . '/../bootstrap.php';

Assert::same(10, Numbers::minMax(12, 1, 10));
Assert::same(1, Numbers::minMax(-5, 1, 10));
Assert::same(5, Numbers::minMax(5, 1, 10));
