<?php declare(strict_types = 1);

namespace Utilitte\Php\DateTime;

final class DateTimeZone
{

	private static \DateTimeZone $timezone;

	public static function getDefaultTimezone(): \DateTimeZone
	{
		return self::$timezone ??= new \DateTimeZone(date_default_timezone_get());
	}

}
