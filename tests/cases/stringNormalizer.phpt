<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Php\StringNormalizer;

require __DIR__ . '/../bootstrap.php';

Assert::same('foo bar', StringNormalizer::normalizeEmoji('foo 🎓 bar'));
Assert::same('foo', StringNormalizer::normalizeEmoji('foo 🎓'));
Assert::same('foo bar', StringNormalizer::normalizeEmoji('foo🎓bar'));
Assert::same('bar', StringNormalizer::normalizeEmoji('🎓bar'));

Assert::same('foo bar', StringNormalizer::normalizeSpaces('foo     bar'));
Assert::same('foo bar', StringNormalizer::normalizeWhitespaces("foo   \r  \n  bar"));
