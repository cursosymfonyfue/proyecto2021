<?php declare(strict_types=1);

namespace App\Tests\Common\Util;

use Symfony\Component\HttpClient\HttpClient;

final class MailHogClient
{
    private string $mailHogBaseUrl;

    public function __construct(string $mailHogBaseUrl)
    {
        $this->mailHogBaseUrl = $mailHogBaseUrl;
    }

    public function clearInbox(): void
    {
        $httpClient = HttpClient::create();
        $httpClient->request('DELETE', sprintf('%s/api/v1/messages', $this->mailHogBaseUrl), []);
    }
}
