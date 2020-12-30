<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Money;

require __DIR__ . '/../bootstrap.php';

Assert::same('1K', Money::formatShort(1000));
Assert::same('1.3K', Money::formatShort(1254));
Assert::same('1.254K', Money::formatShort(1254, 3));
Assert::same('1M', Money::formatShort(1000*1000));
