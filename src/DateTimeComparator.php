<?php declare(strict_types = 1);

namespace Utilitte\Php;

use DateTime;

final class DateTimeComparator
{

	private DateTime $dateTime;

	public function __construct(DateTime $dateTime)
	{
		$this->dateTime = $dateTime;
	}

	public function isSameDate(DateTime $dateTime): bool
	{
		return $this->dateTime->format('Y-m-d') === $dateTime->format('Y-m-d');
	}

}
