<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\Deprecated;
use JetBrains\PhpStorm\ExpectedValues;
use LogicException;

#[Deprecated]
final class TypeCast
{

	#[Deprecated]
	public const ALLOWED_TYPES = [
		'bool', 'int', 'float', 'double', 'string', 'array', 'object', 'mixed',
		'?bool', '?int', '?float', '?double', '?string', '?array', '?object',
	];

	#[Deprecated]
	public static function setType(
		mixed $value,
		#[ExpectedValues(self::ALLOWED_TYPES)]
		string $type,
	): mixed
	{
		if (!in_array($type, self::ALLOWED_TYPES, true)) {
			throw new LogicException(
				sprintf('Type %s cannot be set, allowed are "%s".', $type, implode(', ', self::ALLOWED_TYPES))
			);
		}

		if (str_starts_with($type, '?')) {
			if ($value === null) {
				return null;
			}

			$type = substr($type, 1);
		}

		if ($type !== 'mixed') {
			settype($value, $type);
		}

		return $value;
	}

	/**
	 * @param mixed[] $values
	 * @return mixed[]
	 */
	#[Deprecated]
	public static function setTypes(
		array $values,
		#[ExpectedValues(self::ALLOWED_TYPES)]
		string $type,
	): array
	{
		return array_map(
			fn (mixed $value) => self::setType($value, $type),
			$values,
		);
	}

}
