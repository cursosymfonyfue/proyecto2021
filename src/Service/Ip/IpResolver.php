<?php

declare(strict_types=1);

namespace App\Service\Ip;

use Symfony\Component\HttpFoundation\RequestStack;

final class IpResolver implements IpResolverInterface
{
    /** @var RequestStack */
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function resolveIp(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return null;
        }

        return $request->getClientIp();
    }
}
