<?php declare(strict_types = 1);

namespace Utilitte\Php;

use Utilitte\Php\Exception\TypeAssertionException;

final class TypeAssertion
{

	private const BUILTIN = [
		'bool' => true,
		'int' => true,
		'float' => true,
		'string' => true,
		'array' => true,
		'object' => true,
		'resource' => true,
		'null' => true,
	];

	private const BUILTIN_MAPPING = [
		'integer' => 'int',
		'boolean' => 'bool',
		'double' => 'float',
		'NULL' => 'null',
	];

	/**
	 * @param mixed $variable
	 */
	public static function assertType($variable, string $expectType): void
	{
		$type = gettype($variable);
		$type = self::BUILTIN_MAPPING[$type] ?? $type;

		if ($type === 'unknown type') {
			throw new TypeAssertionException(
				sprintf('Variable is type of "%s", expected "%s"', 'unknown type', $expectType)
			);
		}

		if ($type === 'resource (closed)') {
			$type = 'resource';
		}

		if (!isset(self::BUILTIN[$expectType])) {
			if ($variable instanceof $expectType) {
				return;
			}
		} elseif ($type === $expectType) {
			return;
		}

		throw new TypeAssertionException(
			sprintf('Variable is type of "%s", expected "%s"', self::variableToType($variable, $type), $expectType)
		);
	}

	/**
	 * @param mixed $variable
	 */
	private static function variableToType($variable, string $type): string
	{
		return $type === 'object' ? get_class($variable) : $type;
	}

}
