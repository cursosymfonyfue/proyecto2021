<?php declare(strict_types=1);

namespace App\Tests\Functional\Common\Routing;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// ./vendor/phpunit/phpunit/phpunit --filter=testFrontendRoutes
final class RoutingTest extends WebTestCase
{
    public function testFrontendRoutes() : void
    {
        //self::bootKernel(['debug' => false]);

        $client = static::createClient();
        $crawler = $client->request('GET', 'http://localhost:8000/');
        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('p', 'Your application is now ready and you can start working on it.');
    }
}
