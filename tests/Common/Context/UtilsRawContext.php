<?php declare(strict_types=1);

namespace App\Tests\Common\Context;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;

class UtilsRawContext extends RawMinkContext
{
    private string $screenshotsPath = '';

    public function __construct(string $screenshotsPath)
    {
        $this->screenshotsPath = $screenshotsPath;
    }


    public function takeAScreenshot($prefix = 'screenshot')
    {
        if ($this->supportsJavaScript()) {
            $content = $this->getSession()->getScreenshot();
            $extension = 'jpg';
        } else {
            $content = $this->getSession()->getPage()->getOuterHtml();
            $extension = 'html';
        }

        $baseName = sprintf('%s-%s.%s', $prefix, microtime(), $extension);
        $this->createScreenshotPathIfDoesNotExist();

        file_put_contents(sprintf('%s/%s', $this->screenshotsPath, $baseName), $content);
    }

    protected function supportsJavaScript(): bool
    {
        return $this->getSession()->getDriver() instanceof Selenium2Driver;
    }

    private function createScreenshotPathIfDoesNotExist(): void
    {
        if (!is_dir($this->screenshotsPath)) {
            mkdir($this->screenshotsPath, 0700, true);
        }
    }
}
