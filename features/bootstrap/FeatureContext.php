<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    public $session;
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
        $window = $this->getSession()->getWindowName();
        $this->getSession()->stop($window);
    }

    /**
     * @When I search for :arg1
     */
    public function iSearchFor($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $searchBar = $page->findById("searchBar");
        if(!$searchBar){
            throw new Exception("searchBar could not be found");
        }else{
            $searchBar->setvalue($arg1);
        }
        $addToCloudButton = $page->findById("mergeButton");
        if(!$addToCloudButton){
            throw new Exception("Add To Cloud Button could not be found");
        }else{
            $addToCloudButton->click();
        }
    }

    /**
     * @When I click on the :arg1 button
     */
    public function iClickOnTheButton($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $button = $page->findById($arg1);
        if(!$button){
            throw new Exception("Button" + $arg1 + "could not be found");
        }else{
            $button->click();
        }
    }

    /**
     * @Then I should be at the Artist Search page
     */
    public function iShouldBeAtTheArtistSearchPage()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $wordCloud = $page->findById("WordCloud");
        if($wordCloud->isVisible()){
            throw new Exception("Did not navigate to Artist Search page");
        }
    }

    /**
     * @Given the current page is :arg1
     */
    public function theCurrentPageIs($arg1)
    {
        $session = $this->getSession();
        $session->visit($arg1);
    }

    /**
     * @When I select the word :arg1
     */
    public function iSelectTheWord($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $word = $page->find('named', array('content', $arg1));
        if(!$word){
            throw new Exception("Word " + $arg1 + " could not be found");
        }else{
            $word->click();
        }
    }

    /**
     * @Then I should be at the Word Cloud Page
     */
    public function iShouldBeAtTheWordCloudPage()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $wordCloud = $page->findById("WordCloud");
        if(!$wordCloud->isVisible()){
            throw new Exception("Did not navigate to Artist Search page");
        }
    }

    /**
     * @When I click on the song :arg1
     */
    public function iClickOnTheSong($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $songListDiv = $page->findById("SongList");
        $table_rows = $songListDiv->findAll('css', 'tr');
        foreach($table_rows as $row){
            $table_data = $row->findall('css', 'td');
            if(count($table_data)==0)continue;
            if($table_data[0]->getText() == $arg1){
                $table_data[0]->click();
            }
        }
    }

    /**
     * @Then I should see the songs :arg1 and :arg2 with respective frequencies of :arg3 and :arg4
     */
    public function iShouldSeeTheSongsAndWithRespectiveFrequenciesOfAnd($arg1, $arg2, $arg3, $arg4)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $songListDiv = $page->findById("SongList");
        $table_rows = $songListDiv->findAll('css', 'tr');
        foreach($table_rows as $row){
            $table_data = $row->findall('css', 'td');
            if(count($table_data) == 0) continue;
            if($table_data[0]->getText() == $arg1){
                if($table_data[2]->getText() != $arg3){
                    throw new Exception("Incorrect Song Frequency");
                }
            }else{
                if($table_data[0]->getText() == $arg2){
                    if($table_data[2]->getText() != $arg4){
                        throw new Exception("Incorrect Song Frequency");
                    }
                }else{
                
                throw new Exception("Incorrect Song Displayed");
            }
            }

        }

    }

    /**
     * @Then I should see the word :arg1 at the top of the screen
     */
    public function iShouldSeeTheWordAtTheTopOfTheScreen($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $title = $page->find('named', array('content', $arg1));
        if(!$title){
            throw new Exception("Word title not displayed");
        }
    }

    /**
     * @Then I should see the songs listed in descending frequency
     */
    public function iShouldSeeTheSongsListedInDescendingFrequency()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $songListDiv = $page->findById("SongList");
        $table_rows = $songListDiv->findAll('css', 'tr');
        $count = 999999;
        foreach($table_rows as $row){
            $table_data = $row->findall('css', 'td');
            if(count($table_data) == 0) continue;
            echo($table_data[2]->getText());
            if($table_data[2]->getText() <= $count){
                $count = $table_data[2];
            }else{
                throw new Exception("Song List not in descending order");
            }
        }
    }


    /**
     * @Then I should be at the Song List
     */
    public function iShouldBeAtTheSongList()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $songListDiv = $page->findById("SongList");
        if(!$songListDiv->isVisible()){
            $session->wait(4000);
            throw new Exception("Did not navigate to Song List page");
            $session->wait(4000);
        }
    }


    /**
     * @Given I am on the home page
     */
    public function iAmOnTheHomePage()
    {
        $session = $this->getSession();
        $session->visit("http://localhost");
    }

    /**
     * @When I do nothing
     */
    public function iDoNothing()
    {
        
    }

    /**
     * @Then I should not be able to click search
     */
    public function iShouldNotBeAbleToClickSearch()
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $searchButton = $page->findById("searchButton");
    if(!$searchButton->getAttribute("disabled"))
        throw new Exception("Search not disabled");
    }

    /**
     * @When I type :arg1
     */
    public function iType($arg1)
    {
    $session = $this->getSession();
    $page = $session->getPage();
    $page->findByID("searchBar")->keyPress($arg1);
        
    }

    /**
     * @When I select the suggestion :arg1
     */
    public function iSelectTheTopSuggestion($arg1)
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $page->fillField('searchBar', $arg1);
    

    }

    /**
     * @Then I should be able to click search
     */
    public function iShouldBeAbleToClickSearch()
    {
    $session = $this->getSession();
    $page = $session->getPage();
    $searchButton = $page->findById("searchButton");
    if($searchButton->getAttribute("disabled"))
        throw new Exception("Search disabled");
        $session->executeScript('searchAction()');
    $this->getSession()->wait(2000);
    }

    /**
     * @Then the wordcloud should be displayed with title :arg1
     */
    public function theWordcloudWithTitle($arg1)
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $wc = $page->findById("wCCanvas");
    if($wc->getAttribute("style") != "height: 500px;")
        throw new Exception("wordcloud not displaying");
    $title = $page->findById("wCTitle");
    if(is_null($title)) {
        throw new Exception("No WC Title");
    } else {
        if($title->getText() != $arg1)
            throw new Exception("Wrong WC Title");
    }

    }

    /**
     * @Given I am on the wordcloud page
     */
    public function iAmOnTheWordcloudPage()
    {
    $session = $this->getSession();
    $session->visit("http://localhost");
    $page = $session->getPage();

    $drake = "Drake";
        $page->fillField('searchBar', $drake);
    $session->executeScript('mergeAction()');
    $this->getSession()->wait(2000);
        
    }


    /**
     * @Then I should not be able to click add to cloud
     */
    public function iShouldNotBeAbleToClickAddToCloud()
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $mergeButton = $page->findById("mergeButton");
    if(!$mergeButton->getAttribute("disabled"))
        throw new Exception("Merge not disabled");
    }

    /**
     * @Then I should be able to click add to cloud
     */
    public function iShouldBeAbleToClickAddToCloud()
    {
       $session = $this->getSession();
    $page = $session->getPage();
    $mergeButton = $page->findById("mergeButton");
    if($mergeButton->getAttribute("disabled"))
        throw new Exception("Merge disabled");
        $mergeButton->click();
    $this->getSession()->wait(2000);
    }


    /**
     * @Then the back button should be invisible
     */
    public function theBackButtonShouldBeInvisible()
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $backButton = $page->findById("back");
    if($backButton->isVisible())
        throw new Exception("Back button visible");
    }

    /**
     * @When I click the back button
     */
    public function iClickTheBackButton()
    {
         $session = $this->getSession();
    $page = $session->getPage();
    $backButton = $page->findById("back");
    $backButton->click();
    }

    /**
     * @Then I should be on the home page
     */
    public function iShouldBeOnTheHomePage()
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $wc = $page->findById("wCCanvas");
    if($wc->getAttribute("style") != "height: 1px;")
        throw new Exception("Not on home page");
    }

    /**
     * @Then I should be on the wordcloud page
     */
    public function iShouldBeOnTheWordcloudPage()
    {
        $session = $this->getSession();
    $page = $session->getPage();
    $wc = $page->findById("wCCanvas");
    if($wc->getAttribute("style") != "height: 500px;")
        throw new Exception("Not on wordcloud page");
    }


}
