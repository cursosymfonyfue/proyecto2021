<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\ContactForm\Context;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert as Assert;

final class ContactFormContext extends RawMinkContext implements Context
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Given /^I should see only one row$/
     */
    public function iShouldSeeOnlyOneRow()
    {
        $rows = $this->getSession()->getPage()->findAll('css', '.contact-row');
        Assert::assertCount(1, $rows);
    }

    /**
     * @Given /^The contact form should be saved properly into the database$/
     */
    public function theContactFormShouldBeSavedProperlyIntoTheDatabase()
    {
        $rows = $this->contactRepository->findAll();
        Assert::assertCount(1, $rows);

        /** @var Contact $contactEntity */
        $contactEntity = $rows[0];
        Assert::assertEquals('Edu', $contactEntity->getFullName());
        Assert::assertEquals('Queridos reyes magos', $contactEntity->getSubject());
        Assert::assertEquals('Me gustaría que me trajeran un portátil de 3.000 pavos', $contactEntity->getBody());
    }
}
