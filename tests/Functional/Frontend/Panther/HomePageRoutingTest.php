<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\Panther;

use Symfony\Component\Panther\PantherTestCase;

// ./vendor/phpunit/phpunit/phpunit tests/Functional/Frontend/Panther/HomePageRoutingTest.php
final class HomePageRoutingTest extends PantherTestCase
{
    public function testHomePage(): void
    {
        // Si no indicamos browser, tomará chrome por defecto
        $client = self::createPantherClient(['browser' => self::CHROME]);
        // $client = self::createPantherClient(['browser' => self::FIREFOX]);

        $client->request('GET', 'http://test.cursosymfonyfue.local:81/');

        // Si el selector .phrase-of-the-day no está visible, la siguiente línea fallará:
        // $this->assertSelectorTextContains('div', 'Phrase of the day:'); // se mira sobre el div, no sobre el hijo (span)

        $this->assertSelectorTextContains('h1', 'Bienvenid@s al Curso de Symfony Fue');

        $client->waitForVisibility('.phrase-of-the-day');
        $this->assertSelectorTextContains('div', 'Phrase of the day:'); // se mira sobre el div, no sobre el hijo (span)

        // En otros casos puede venir bien, ahora sería redundante:
        // $this->assertSelectorWillExist('.phrase-of-the-day');

        // Guardamos pantallazo
        // $client->takeScreenshot('./var/screenshots/test/output.png');

        // Mostramos toda la salida del html (sin js renderizado)
        // echo $client->getCrawler()->html();
    }
}
