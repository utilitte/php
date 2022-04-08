<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\Deprecated;
use Nette\Utils\Strings;

#[Deprecated]
final class Formatter
{

	#[Deprecated]
	public static function formatNumberShortcut($number): string
	{
		if ($number < 1000) {
			return (string)(int) $number;
		} elseif ($number < 1000000) {
			$number /= 1000;
			if ($number > 99) {
				$number = (int) $number;
			} else {
				$number = number_format($number, 1);
				if (Strings::endsWith($number, '.0')) {
					$number = (int) $number;
				}
			}

			return $number . 'K';
		} elseif ($number < 1000000000) {
			$number /= 1000000;
			if ($number > 99) {
				$number = (int) $number;
			} else {
				$number = number_format($number, 1);
				if (Strings::endsWith($number, '.0')) {
					$number = (int) $number;
				}
			}

			return $number . 'M';
		} elseif ($number < 1000000000000) {
			$number /= 1000000000;
			if ($number > 99) {
				$number = (int) $number;
			} else {
				$number = number_format($number, 1);
				if (Strings::endsWith($number, '.0')) {
					$number = (int) $number;
				}
			}

			return $number . 'B';
		} else {
			$number /= 1000000000000;
			if ($number > 99) {
				$number = (int) $number;
			} else {
				$number = number_format($number, 1);
				if (Strings::endsWith($number, '.0')) {
					$number = (int) $number;
				}
			}

			return $number . 'T';
		}
	}

}
