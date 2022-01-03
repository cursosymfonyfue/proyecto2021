<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\HomePageLikes\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert as Assert;

final class HomePageLikesContext extends RawMinkContext implements Context
{
    private int $firstPostNumberOfLikes = 0;

    /**
     * @Then /^I click on the "([^"]*)" like$/
     */
    public function iClickOnTheFirstLike(string $position)
    {
        $indexes = ['first' => 1, 'second' => 2, 'third' => 3];
        $index = $indexes[$position];
        $id = 'like-' . $index;

        $nodeLike = $this->getSession()->getPage()->findById($id);
        $nodeLike->click();
    }

    /**
     * @Then The number of likes for the :position post should be :total
     */
    public function theNumberOfLikesForThePostShouldBe($position, $total)
    {
        $indexes = ['first' => 1, 'second' => 2, 'third' => 3];
        $index = $indexes[$position];
        $id = 'like-' . $index;

        $nodeLike = $this->getSession()->getPage()->findById($id);
        Assert::assertEquals((int)$nodeLike->getText(), $total);
    }

    /**
     * @Then /^I click on the first Likes counter$/
     */
    public function iClickOnTheFirstLikesCounter()
    {
        $likes = $this->getSession()->getPage()->findAll('css', '.counter');
        $nodeLike = $likes[0];
        $nodeLike->click();
    }

    /**
     * @Then /^I click on "([^"]*)"$/
     */
    public function iClickOn($text)
    {
        $node = $this->getSession()->getPage()->find('named', ['content', $text]);
        // $likes = $this->getSession()->getParent()->find('xpath', sprintf('//*[text()[contains(.,"%s")]]', $text));
        $node->click();
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
