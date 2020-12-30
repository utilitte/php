<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Numbers;

require __DIR__ . '/../bootstrap.php';

Assert::same('1 kB', Numbers::bytes(1024));
Assert::same('1 MB', Numbers::bytes(1024 * 1024));
Assert::same('1 GB', Numbers::bytes(1024 * 1024 * 1024));
Assert::same('1 TB', Numbers::bytes(1024 * 1024 * 1024 * 1024));
Assert::same('1 PB', Numbers::bytes(1024 * 1024 * 1024 * 1024 * 1024));
Assert::same('2.1 PB', Numbers::bytes(1024 * 1024 * 1024 * 1024 * 1024 * 2.1));
Assert::same('2.23 PB', Numbers::bytes(1024 * 1024 * 1024 * 1024 * 1024 * 2.234));
