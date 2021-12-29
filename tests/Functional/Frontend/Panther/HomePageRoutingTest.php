<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\Panther;

use Symfony\Component\Panther\PantherTestCase;

// ./vendor/phpunit/phpunit/phpunit tests/Functional/Frontend/Panther/HomePageRoutingTest.php
// SYMFONY_DEPRECATIONS_HELPER=disabled ./vendor/phpunit/phpunit/phpunit tests/Functional/Frontend/Panther/HomePageRoutingTest.php --stop-on-failure --testdox
// Tip: PANTHER_NO_HEADLESS=1
final class HomePageRoutingTest extends PantherTestCase
{
    public function testHomePage(): void
    {
        $client = self::createPantherClient(['browser' => self::CHROME]); // Si no indicamos browser, tomará chrome por defecto
        $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Bienvenid@s al Curso de Symfony Fue');

        $client->waitForVisibility('.phrase-of-the-day');
        $this->assertSelectorTextContains('div', 'Phrase of the day:'); // se mira sobre el div, no sobre el hijo (span)

        // En otros casos puede venir bien, ahora sería redundante: $this->assertSelectorWillExist('.phrase-of-the-day');

        // Guardamos pantallazo
        // $client->takeScreenshot('./var/screenshots/test/output.png');

        // Mostramos toda la salida del html (sin js renderizado)
        // echo $client->getCrawler()->html();
    }
}
