<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus;

use LogicException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionException;

/**
 * This class is responsible for determining the type of the first parameter of callable objects.
 * It is particularly useful for matching event handlers or similar callable objects with their
 * intended processing logic based on the parameter type they expect.
 */
final class CallableFirstParameterExtractor
{
    /**
     * Extracts the first parameter type of the '__invoke' method from a collection of callable objects.
     * @param iterable $callables A collection of callable objects.
     * @return array An associative array mapping each callable to the type of its first parameter.
     */
    public static function forCallables(iterable $callables): array
    {
        return array_map(static fn($handler) => is_object($handler) ? self::extract($handler) : null, (array)$callables);
    }

    /**
     * Extracts the type of the first parameter of a callable object's '__invoke' method.
     * @param object $handler The callable object to inspect.
     * @return string|null The type of the first parameter, or null if it's not applicable or can't be determined.
     */
    private static function extract(object $handler): ?string
    {
        try {
            $reflector = new ReflectionClass($handler);
            $method = $reflector->getMethod('__invoke');
        } catch (ReflectionException $e) {
            throw new LogicException("Error processing handler: " . $e->getMessage(), 0, $e);
        }

        // Check if the method has exactly one parameter.
        if ($method->getNumberOfParameters() === 1) {
            $firstParameterType = $method->getParameters()[0]->getType();

            // Check if the parameter type is not a built-in type (e.g., int, string) and return its name.
            if ($firstParameterType instanceof ReflectionNamedType && !$firstParameterType->isBuiltin()) {
                return $firstParameterType->getName();
            }
        }
        return null;
    }
}
