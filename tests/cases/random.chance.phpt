<?php declare(strict_types = 1);

// phpcs:ignoreFile

use Tester\Assert;
use Utilitte\Php\Random;

require __DIR__ . '/../bootstrap.php';

Assert::true(Random::chance(100));
Assert::true(Random::chance(101, false));
Assert::false(Random::chance(0));
Assert::false(Random::chance(-1, false));

Assert::exception(fn () => Random::chance(-1), InvalidArgumentException::class);
Assert::exception(fn () => Random::chance(101), InvalidArgumentException::class);
