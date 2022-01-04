<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\ContactForm\Context;

use App\Tests\Common\Util\MailHogClient;
use App\Tests\Functional\Frontend\BehatMink\ContactForm\DataFixtures\DataFixturesInitializer;
use Behat\Behat\Context\Context;

final class InitializerContext implements Context
{
    private DataFixturesInitializer $dataFixturesInitializer;
    private MailHogClient           $mailHogClient;

    public function __construct(DataFixturesInitializer $dataFixturesInitializer, MailHogClient $mailHogClient)
    {
        $this->dataFixturesInitializer = $dataFixturesInitializer;
        $this->mailHogClient = $mailHogClient;
    }

    /** @BeforeScenario */
    public function initializeDatabase()
    {
        $this->dataFixturesInitializer->initialize();
    }

    /** @BeforeScenario */
    public function initializeMailHog()
    {
        $this->mailHogClient->clearInbox();
    }
}
