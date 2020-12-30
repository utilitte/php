<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Exception\TypeAssertionException;
use Utilitte\Php\TypeAssertion;

require __DIR__ . '/../bootstrap.php';

Assert::exception(fn () => TypeAssertion::assertType('string', 'int'), TypeAssertionException::class);
Assert::exception(fn () => TypeAssertion::assertType(new stdClass(), 'int'), TypeAssertionException::class);
Assert::exception(fn () => TypeAssertion::assertType('string', 'stdClass'), TypeAssertionException::class);

TypeAssertion::assertType(15, 'int');
TypeAssertion::assertType(new stdClass(), stdClass::class);
