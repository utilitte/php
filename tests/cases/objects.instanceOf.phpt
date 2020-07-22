<?php declare(strict_types = 1);

// phpcs:ignoreFile

use Tester\Assert;
use Utilitte\Php\Objects;

require __DIR__ . '/../bootstrap.php';

class A { }

class B extends A { }

Assert::true(Objects::instanceOf(B::class, A::class));
Assert::true(Objects::instanceOf(A::class, A::class));

Assert::false(Objects::instanceOf(A::class, B::class));
Assert::false(Objects::instanceOf(A::class, stdClass::class));
