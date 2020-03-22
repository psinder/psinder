<?php

namespace Sip\Psinder\E2E\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Faker\Factory;
use Sip\Psinder\E2E\Collection\Adopters;
use Sip\Psinder\E2E\Collection\Tokens;

class AdopterContext implements Context
{
    /** @var Tokens */
    private $tokens;
    private Adopters $adopters;
    /** @var mixed[] */
    private $adopter;

    public function __construct(Adopters $adopters, Tokens $tokens)
    {
        $this->adopter = [];
        $this->tokens = $tokens;
        $this->adopters = $adopters;
    }

    /**
     * @Given information about adopter
     */
    public function givenAdopter(TableNode $table)
    {
        $this->adopter = array_combine($table->getRow(0), $table->getRow(1));

        $faker = Factory::create();
        $this->adopter['email'] = $faker->email;
        $this->adopter['password'] = $faker->password;
    }

    /**
     * @Given /^logged in as example adopter$/
     */
    public function givenExampleAdopter()
    {
        $token = $this->tokens->obtain(
            'example@adopter.com',
            'baz'
        );

        if ($token === null) {
            throw new \RuntimeException('Cannot retrieve token');
        }

        $this->adopter['id'] = $token->getClaim('jti');
    }

    /**
     * @When /^I register example adopter/
     */
    public function whenRegisterAdopter(TableNode $table)
    {
        $this->adopter = array_combine($table->getRow(0), $table->getRow(1));

        $faker = Factory::create();
        $this->adopter['email'] = $faker->email;
        $this->adopter['password'] = $faker->password;

        $id = $this->adopters->register($this->adopter);

        $this->adopter['id'] = $id;
    }

    /**
     * @Then /^I should be able to log in as adopter$/
     */
    public function thenCanLogIn()
    {
        $token = $this->tokens->obtain(
            $this->adopter['email'],
            $this->adopter['password']
        );

        Assertion::notNull($token);
    }
}
