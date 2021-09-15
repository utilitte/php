<?php declare(strict_types = 1);

namespace Utilitte\Php;

use DateTime;

final class DateTimeUtility
{

	public static function isToday(DateTime $dateTime): bool
	{
		return $dateTime->format('Y-m-d') === date('Y-m-d');
	}

	public static function diffInDays(DateTime $dateTime, DateTime $dateTime2): int
	{
		return (int) $dateTime->diff($dateTime2)->format('%a');
	}

}
