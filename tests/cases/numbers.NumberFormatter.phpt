<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Numbers\NumberFormatter;

require __DIR__ . '/../bootstrap.php';

// non-fixed
Assert::same('0.2', NumberFormatter::formatNumber(0.2));
Assert::same('10', NumberFormatter::formatNumber(10));
Assert::same('-10', NumberFormatter::formatNumber(-10));
Assert::same('10', NumberFormatter::formatNumber('10'));
Assert::same('-10', NumberFormatter::formatNumber('-10'));
Assert::same('10', NumberFormatter::formatNumber('10', 2));
Assert::same('10.25', NumberFormatter::formatNumber('10.254', 2));
Assert::same('10.26', NumberFormatter::formatNumber('10.255', 2));

// fixed
Assert::same('0.2000', NumberFormatter::formatNumber(0.2, fixed: true));
Assert::same('0.20', NumberFormatter::formatNumber(0.2, 2, true));

// invalid
Assert::null(NumberFormatter::formatNumber('foo'));
Assert::null(NumberFormatter::formatNumber(INF));
Assert::null(NumberFormatter::formatNumber(NAN));
Assert::null(NumberFormatter::formatNumber('0,2'));
Assert::null(NumberFormatter::formatNumber('a0.2'));

// percentage
Assert::same('+0.20%',NumberFormatter::formatPercentage(0.2));
Assert::same('+100.00%',NumberFormatter::formatPercentage(100));
Assert::same('100.00%',NumberFormatter::formatPercentage(100, sign: false));
Assert::same('+100%',NumberFormatter::formatPercentage(100, fixed: false));
Assert::same('-20.00%',NumberFormatter::formatPercentage(-20));

// formatShort
Assert::same('500', NumberFormatter::formatShort(500));
Assert::same('1K', NumberFormatter::formatShort(1000));
Assert::same('20K', NumberFormatter::formatShort(20000));
Assert::same('1.3K', NumberFormatter::formatShort(1254, 1));
Assert::same('1.254K', NumberFormatter::formatShort(1254, 3));
Assert::same('1M', NumberFormatter::formatShort(1000*1000));

// formatBytes
Assert::same('1kB', NumberFormatter::formatBytes(1024));
Assert::same('1MB', NumberFormatter::formatBytes(1024 * 1024));
Assert::same('1GB', NumberFormatter::formatBytes(1024 * 1024 * 1024));
Assert::same('1TB', NumberFormatter::formatBytes(1024 * 1024 * 1024 * 1024));
Assert::same('1PB', NumberFormatter::formatBytes(1024 * 1024 * 1024 * 1024 * 1024));
Assert::same('2.1PB', NumberFormatter::formatBytes(1024 * 1024 * 1024 * 1024 * 1024 * 2.1));
Assert::same('2.234PB', NumberFormatter::formatBytes(1024 * 1024 * 1024 * 1024 * 1024 * 2.234));
