<?php

use Utilitte\Php\Fiber\FiberLoop;

require __DIR__ . '/vendor/autoload.php';

function bench(callable $callback, ... $values) {
	$ms = microtime(true);

	for ($i = 0; $i < 1e4; $i++) {
		$callback(...$values);
	}

	$ms = microtime(true) - $ms;

	echo "Time: $ms\n";
}

var_dump(array_column([['asd' => 'xxx']], 'xxx'));

//bench(function ($values, $value) {
//	foreach ($values as $key => $val) {
//		if ($val === $value) {
//			unset($values[$key]);
//		}
//	}
//
//	return $values;
//}, ['val', 'xxx', 'wsd'], 'wsd');
//
//bench(function ($values, $value) {
//	$ret = [];
//	foreach ($values as $key => $val) {
//		if ($val !== $value) {
//			$ret[$key] = $val;
//		}
//	}
//
//	return $ret;
//}, ['val', 'xxx', 'wsd'], 'wsd');
