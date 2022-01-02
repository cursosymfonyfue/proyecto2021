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

    /** @throws \Exception */
    protected function spins($closure, $seconds = 5, $fraction = 4): bool
    {
        $max = $seconds * $fraction;
        $i = 1;
        while ($i++ <= $max) {
            if ($closure($this)) {
                return true;
            }
            $this->getSession()->wait(1000 / $fraction);
        }

        $backtrace = debug_backtrace();
        throw new \Exception(
            sprintf("Timeout thrown by %s::%s()\n%s, line %s",
                $backtrace[0]['class'], $backtrace[0]['function'],
                $backtrace[0]['file'], $backtrace[0]['line']
            )
        );
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
