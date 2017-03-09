<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    public function __construct()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('chrome');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
    }

    public function __destruct()
    {
        $this->getSession()->stop();
    }

    /**
     * @Given the current page is :arg1
     */
    public function theCurrentPageIs($arg1)
    {
        /* get to word cloud page */
        $session = $this->getSession();
        $session->visit("http://localhost");
        $page = $session->getPage();
        $tokens = explode(' ', $arg1);
        $search_query = $tokens[0];
        for ($i = 1; $i < count($tokens) - 2; $i++) {
            $search_query = $search_query . ' ' . $tokens[$i];
        }
	$page->fillField('searchBar', $search_query);
/*
        $searchbar = $page->findField('searchBar'); 
        $searchbar->fillField($search_query);
*/
	$session->executeScript('mergeAction()');	

	//$page->pressButton('mergeButton');
/*
        $wordcloudButton = $page->find('named', array('id', 'mergeButton'));
        $wordcloudButton->click();
*/
    }

    /**
     * @Given the highlighted word is :arg1
     */
    public function theHighlightedWordIs($arg1)
    {
        /* click arg1 */
        /*
        $session = $this->getSession();
        $page = $session->getPage();
        $word = page->find('named', array('content', $arg1));
        $word->click();
         */
        throw new PendingException();
    }

    /**
     * @When I click :arg1
     */
    public function iClick($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the new current page is :arg1
     */
    public function theNewCurrentPageIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the page contents are the lyrics to :arg1
     */
    public function thePageContentsAreTheLyricsTo($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then all occurances of :arg1 on the page are highlighted
     */
    public function allOccurancesOfOnThePageAreHighlighted($arg1)
    {
        throw new PendingException();
    }
}
