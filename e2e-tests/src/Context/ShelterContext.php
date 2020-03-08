<?php

namespace Sip\Psinder\E2E\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Faker\Factory;
use Sip\Psinder\E2E\Collection\Shelters;
use Sip\Psinder\E2E\Collection\Tokens;

class ShelterContext implements Context
{
    /** @var Shelters */
    private $shelters;

    /** @var mixed[] */
    private $shelter;

    /** @var Tokens */
    private $tokens;

    public function __construct(Shelters $shelters, Tokens $tokens)
    {
        $this->shelters = $shelters;
        $this->shelter = [];
        $this->tokens = $tokens;
    }

    /**
     * @Given /^information about shelter:$/
     */
    public function givenShelter(TableNode $table)
    {
        $this->shelter = array_combine($table->getRow(0), $table->getRow(1));

        $faker = Factory::create();
        $this->shelter['email'] = $faker->email;
        $this->shelter['password'] = $faker->password;
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
    public function thenCanLogIn()
    {
        $token = $this->tokens->obtain(
            $this->shelter['email'],
            $this->shelter['password']
        );

        Assertion::notNull($token);
    }
}
