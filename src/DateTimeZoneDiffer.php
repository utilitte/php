<?php declare(strict_types = 1);

namespace Utilitte\Php;

use DateTime;
use DateTimeZone;

final class DateTimeZoneDiffer
{

	private const FORMAT = 'Y-m-d H:i:s';

	/** @var int[] */
	private static array $timeZones;

	public static function diff(DateTimeZone|string $timeZone, DateTimeZone|string|null $baseTimeZone = null): int
	{
		if (!isset(self::$timeZones)) {
			self::$timeZones = require __DIR__ . '/../resources/timezones.php';
		}

		$timeZoneName = strtolower(self::toString($timeZone));
		$baseTimeZoneName = strtolower(self::toString($baseTimeZone));

		if (isset(self::$timeZones[$timeZoneName]) && isset(self::$timeZones[$baseTimeZoneName])) {
			return self::$timeZones[$timeZoneName] - self::$timeZones[$baseTimeZoneName];
		}

		return self::calculateDiff($timeZone, $baseTimeZone);
	}

	public static function adjustByTimeZone(DateTime $dateTime, DateTimeZone|string $timeZone): DateTime
	{
		$diff = -self::diff($timeZone);

		return $dateTime->modify(sprintf('%s %d seconds', $diff >= 0 ? '+' : '-', abs($diff)));
	}

	private static function toString(DateTimeZone|string|null $timeZone): string
	{
		if (is_string($timeZone)) {
			return $timeZone;
		}

		if ($timeZone === null) {
			return date_default_timezone_get();
		}

		return $timeZone->getName();
	}

	private static function calculateDiff(DateTimeZone|string $timeZone, DateTimeZone|string|null $baseTimeZone = null): int
	{
		if (is_string($timeZone)) {
			$timeZone = new DateTimeZone($timeZone);
		}

		if ($baseTimeZone === null) {
			$baseTimeZone = new DateTimeZone(date_default_timezone_get());
		} elseif (is_string($baseTimeZone)) {
			$baseTimeZone = new DateTimeZone($baseTimeZone);
		}

		$baseDateTimeFormat = (new DateTime('now', $baseTimeZone))->format(self::FORMAT);
		$dateTimeFormat = (new DateTime('now', $timeZone))->format(self::FORMAT);

		$diff = (new DateTime($baseDateTimeFormat))->diff(new DateTime($dateTimeFormat));

		$seconds = $diff->s;
		$seconds += $diff->i * 60; // minutes
		$seconds += $diff->h * 3600; // hours
		$seconds += $diff->d * 86400; // days

		if ($diff->invert === 1) {
			return -$seconds;
		}

		return $seconds;
	}

}
