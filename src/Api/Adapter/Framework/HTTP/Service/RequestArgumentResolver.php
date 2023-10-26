<?php

declare(strict_types=1);

namespace Api\Adapter\Framework\HTTP\Service;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Api\Adapter\Framework\HTTP\DTO\RequestDTO;

readonly class RequestArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private RequestTransformer $requestTransformer
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (null === $argument->getType()) {
            return false;
        }

        return (new ReflectionClass($argument->getType()))->implementsInterface(RequestDTO::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $this->requestTransformer->transform($request);

        $class = $argument->getType();

        yield new $class($request);
    }
}
