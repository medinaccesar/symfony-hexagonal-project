<?php

namespace Common\Infrastructure\Service\Symfony\Serializer;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

readonly class SerializerService
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * Converts an entity to an array.
     *
     * @param object $entity The entity to be serialized.
     * @param array $groups Serialization groups (optional).
     * @return array|null The serialized entity as an array, or null on failure.
     */
    public function entityToArray(object $entity, array $groups = []): ?array
    {
        try {
            $context = !empty($groups) ? ['groups' => $groups] : [];
            return $this->serializer->normalize($entity, null, $context);
        } catch (ExceptionInterface) {
            // Log the error or handle it as required
            return null;
        }
    }
}
