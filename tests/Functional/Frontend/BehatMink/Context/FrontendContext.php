<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\RawMinkContext;

final class FrontendContext extends RawMinkContext implements Context
{
    /**
     * @Then /^I click on "([^"]*)"$/
     */
    public function iClickOn($text)
    {
        $likes = $this->getSession()->getPage()->findAll('css', '.counter');
dump(count($likes)); die();
        /** @var NodeElement $nodeLike */
        $nodeLike = $likes[0];
        $nodeLike->click();
        dump($nodeLike->getOuterHtml()); die();
    }
}
