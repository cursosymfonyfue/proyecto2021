<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\HomePageLikes\Context;

use App\Tests\Functional\Frontend\BehatMink\HomePageLikes\DataFixtures\DataFixturesInitializer;
use Behat\Behat\Context\Context;

final class InitializerContext implements Context
{
    private DataFixturesInitializer $dataFixturesInitializer;

    public function __construct(DataFixturesInitializer $dataFixturesInitializer)
    {
        $this->dataFixturesInitializer = $dataFixturesInitializer;
    }

    /** @BeforeScenario */
    public function initialize()
    {
        $this->dataFixturesInitializer->initialize();
    }
}
