<?php declare(strict_types = 1);

namespace Utilitte\Php;

use JetBrains\PhpStorm\Deprecated;
use Utilitte\Php\Exception\TypeAssertionException;

#[Deprecated]
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
	#[Deprecated]
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
			sprintf('Variable is type of "%s", expected "%s"', get_debug_type($variable), $expectType)
		);
	}

}
