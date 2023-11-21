<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus;

use LogicException;
use ReflectionClass;
use ReflectionNamedType;

/**
 * Utility class for extracting the type of the first parameter of callable objects.
 * This class provides a method to determine the type of the first parameter of a callable object's '__invoke' method.
 * It is used primarily in situations where callable objects (like event handlers) need to be matched with appropriate
 * processing based on the type of their first parameter.
 */
final class CallableFirstParameterExtractor
{
    /**
     * Processes an iterable of callables and extracts the type of the first parameter of their '__invoke' method.
     *
     * @param iterable $callables An iterable of callable objects.
     * @return array An array containing the types of the first parameter of each callable.
     */
    public static function forCallables(iterable $callables): array
    {
        return array_map(static fn($handler) => is_object($handler) ? self::extract($handler) : null, (array)$callables);
    }

    /**
     * Extracts the type of the first parameter of a callable object's '__invoke' method.
     *
     * @param object $handler The callable object.
     * @return string|null The type of the first parameter, or null if it cannot be determined.
     */
    private static function extract(object $handler): ?string
    {
        try {
            $reflector = new ReflectionClass($handler);
            $method = $reflector->getMethod('__invoke');
        } catch (\ReflectionException $e) {
            throw new LogicException("Error processing handler: " . $e->getMessage(), 0, $e);
        }
        if ($method->getNumberOfParameters() === 1) {
            $firstParameterType = $method->getParameters()[0]->getType();
            if ($firstParameterType instanceof ReflectionNamedType && !$firstParameterType->isBuiltin()) {
                return $firstParameterType->getName();
            }
        }
        return null;
    }
}
