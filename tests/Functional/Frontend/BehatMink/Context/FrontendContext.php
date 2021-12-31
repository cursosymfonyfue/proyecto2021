<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert as Assert;

final class FrontendContext extends RawMinkContext implements Context
{
    private int $firstPostNumberOfLikes = 0;

    /**
     * @Then /^I click on "([^"]*)"$/
     */
    public function iClickOn($text)
    {
        $likes = $this->getSession()->getPage()->findAll('css', '.counter');
        $nodeLike = $likes[0];
        $nodeLike->click();
    }

    /**
     * @Given /^I keep with the first post number of likes$/
     */
    public function iKeepWithTheFirstPostNumberOfLikes()
    {
        $likes = $this->getSession()->getPage()->findAll('css', '.counter');
        $nodeLike = $likes[0];
        $firstPostNumberOfLikes = (int)$nodeLike->getText();
        $this->firstPostNumberOfLikes = $firstPostNumberOfLikes;
    }

    /**
     * @Then /^First post number of likes should be increased by one$/
     */
    public function firstPostNumberOfLikesShouldBeIncreasedByOne()
    {
        $likes = $this->getSession()->getPage()->findAll('css', '.counter');
        $nodeLike = $likes[0];
        $firstPostNumberOfLikes = (int)$nodeLike->getText();
        Assert::assertEquals($firstPostNumberOfLikes, $this->firstPostNumberOfLikes + 1);
    }
}
