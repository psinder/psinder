<?php

namespace Sip\Psinder\E2E\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Sip\Psinder\E2E\Collection\Offers;
use Sip\Psinder\E2E\Collection\Shelters;

class ShelterContext implements Context
{
    /** @var Shelters */
    private $shelters;

    /** @var mixed[] */
    private $shelter;

    public function __construct(Shelters $shelters)
    {
        $this->shelters = $shelters;
        $this->shelter = [];
    }

    /**
     * @Given /^information about shelter:$/
     */
    public function givenShelter(TableNode $table)
    {
        $this->shelter = array_combine($table->getRow(0), $table->getRow(1));
    }

    /**
     * @When /^I register shelter$/
     */
    public function whenRegisterShelter()
    {
        $id = $this->shelters->create($this->shelter);

        $this->shelter['id'] = $id;
    }

    /**
     * @Then /^I should be able to log in$/
     */
    public function thenOfferVisibleOnList()
    {
    }
}
