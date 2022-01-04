<?php declare(strict_types=1);

namespace App\Tests\Common\Context;

use Behat\Behat\Hook\Scope\AfterStepScope;

final class UtilsContext extends UtilsRawContext
{
    /** @AfterStep */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $this->takeAScreenShot('error');
        }
    }

    /** @When /^I take a screenshot "([^"]*)"$/i */
    public function iTakeScreenShot($fileName = null)
    {
        $this->takeAScreenShot($fileName);
    }

    /** @When I navigate from a desktop browser */
    public function iNavigateFromADesktopBrowser()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(1024, 768);
        }
    }

    /** @When I navigate from a mobile device */
    public function iNavigateFromAMobileDevice()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(360, 480);
        }
    }

    /** @When I navigate from a tablet device */
    public function iNavigateFromATabledDevice()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(768, 1024);
        }
    }
}
