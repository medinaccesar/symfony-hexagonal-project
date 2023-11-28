<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Resolver;

use Common\Infrastructure\Adapter\REST\Symfony\Transformer\RequestTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Resolver for transforming request arguments in a Symfony application.
 *
 * This class implements the ValueResolverInterface to transform incoming HTTP requests
 * into suitable arguments for controller methods, facilitating the handling of request data.
 */
readonly class RequestArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private RequestTransformer $requestTransformer
    ) {
    }

    /**
     * Resolves the arguments for a controller method from the request.
     * This method is called by Symfony to transform the request into suitable arguments for
     * the controller method being invoked. It leverages the RequestTransformer to achieve this.
     *
     * @param Request          $request  the current HTTP request
     * @param ArgumentMetadata $argument metadata about the controller argument being resolved
     *
     * @return \Generator yields the transformed argument for the controller method
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->requestTransformer->transform($request, $argument->getType());
    }
}
