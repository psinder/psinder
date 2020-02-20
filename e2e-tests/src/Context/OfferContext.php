<?php

namespace Sip\Psinder\E2E\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Sip\Psinder\E2E\Collection\Offers;

class OfferContext implements Context
{
    /** @var Offers */
    private $offers;

    /** @var mixed[] */
    private $offer;

    public function __construct(Offers $offers)
    {
        $this->offers = $offers;
        $this->offer = [];
    }

    /**
     * @Given /^example shelter$/
     */
    public function givenExampleShelter()
    {
        $this->offer['shelterId'] = 'baec7e53-bbc9-4537-9541-d6a8df844c6a';
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
}
