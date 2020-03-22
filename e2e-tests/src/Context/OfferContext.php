<?php

namespace Sip\Psinder\E2E\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\E2E\Collection\Api\ApiTokens;
use Sip\Psinder\E2E\Collection\Offers;

class OfferContext implements Context
{
    private Offers $offers;
    /** @var mixed[] */
    private array $offer;
    private ApiTokens $tokens;

    public function __construct(Offers $offers, ApiTokens $tokens)
    {
        $this->offers = $offers;
        $this->offer = [];
        $this->tokens = $tokens;
    }

    /**
     * @Given /^logged in as example shelter$/
     */
    public function givenExampleShelter()
    {
        $token = $this->tokens->obtain(
            'example@shelter.com',
            'foobar'
        );

        if ($token === null) {
            throw new \RuntimeException('Cannot retrieve token');
        }

        $this->offer['shelterId'] = $token->getClaim('jti');
    }

    /**
     * @Given /^information about pet:$/
     */
    public function givenPet(TableNode $table)
    {
        $this->offer['pet'] = array_combine($table->getRow(0), $table->getRow(1));
    }

    /**
     * @When /^I post an offer$/
     */
    public function whenPostOffer()
    {
        $id = $this->offers->post($this->offer);

        $this->offer['id'] = $id;
    }

    /**
     * @Then /^it should be visible on offer list$/
     */
    public function thenOfferVisibleOnList()
    {
        $result = $this->offers->get($this->offer['id']);

        Assertion::notNull($result, 'Offer is not visible on list');
        Assertion::eq($this->offer['pet']['name'], $result['pet']['name']);
        Assertion::eq($this->offer['pet']['sex'], $result['pet']['sex']);
        Assertion::eq($this->offer['pet']['birthday'], $result['pet']['birthday']);
        Assertion::eq($this->offer['pet']['type'], $result['pet']['type']);
        Assertion::eq($this->offer['pet']['breed'], $result['pet']['breed']);
    }

    /**
     * @When /^I apply to offer$/
     */
    public function whenApplyToThisOffer()
    {
        $this->offers->apply(
            $this->offer['id'],
            $this->tokens->current()->getClaim('jti')
        );
    }

    /**
     * @Then /^I should be visible on offer applicants list$/
     */
    public function thenShouldBeVisibleOnApplicationList()
    {
        $applications = $this->offers->getApplications(
            $this->offer['id']
        );

        assert(count($applications) === 1);
        assert($applications[0]['offerId'] === $this->offer['id']);
        assert($applications[0]['adopterId'] === $this->tokens->current()->getClaim('jti'));
    }
}
