<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Resolver;

use Common\Infrastructure\Adapter\REST\Symfony\Transformer\RequestTransformer;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

readonly class RequestArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private RequestTransformer $requestTransformer
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $this->requestTransformer->transform($request);
        $class = $argument->getType();
        yield new $class($request);
    }
}
