<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\Arrays;

require __DIR__ . '/../bootstrap.php';


Assert::same([
	5 => ['id' => 5],
	6 => ['id' => 6],
], Arrays::columnAsKey([
	['id' => 5], ['id' => 6],
], 'id'));
