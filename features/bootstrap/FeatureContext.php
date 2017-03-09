<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

<<<<<<< HEAD
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;

use Behat\MinkExtension\Context\MinkContext;

=======
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;

>>>>>>> origin/alec-testing
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
<<<<<<< HEAD
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


=======
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
	 * @Given the current page is :arg1 word cloud
	 */
	public function theCurrentPageIsWordCloud($arg1)
	{
		/* get to word cloud page */
		$session = $this->getSession();
		$session->visit("http://localhost");
		$page = $session->getPage();
		$tokens = explode(' ', $arg1);
		$search_query = $tokens[0];
		for ($i = 1; $i < count($tokens); $i++) {
			$search_query = $search_query . ' ' . $tokens[$i];
		}
		$page->fillField('searchBar', $search_query);

		$page->pressButton('mergeButton');
	}

	/**
	 * @When I click :arg1
	 */
	public function iClick($arg1)
	{
		/* click arg1 */
		$session = $this->getSession();
		$page = $session->getPage();
		$word = $page->find('named', array('content', $arg1));
		$session->wait(100);
		$word->click();
	}

	/**
	 * @Then the page title is :arg1 by :arg2
	 */
	public function thePageTitleIs($arg1, $arg2)
	{
		$expected_title = $arg1.' by '.$arg2;
		$page_title = $this->getSession()->getPage()->find('css', 'title')->getText();
		if ($page_title != $expected_title) {
			throw new Exception("Page title should be ".$expected_title."but is ".$page_title." instead.");
		}
	}

	/**
	 * @Then the page contents are the lyrics to :arg1
	 */
	public function thePageContentsAreTheLyricsTo($arg1)
	{
		// lyrics oracle
		$expected_lyrics;
		if ($arg1 == "Breakaway") {
			$expected_lyrics = "Breakaway Grew up in a small town 
				And when the rain would fall down 
				I'd just stare out my window 
				Dreamin' of what could be 
				And if I'd end up happy 
				I would pray 

				Trying hard to reach out 
				But, when I tried to speak out 
				Felt like no one could hear me 
				Wanted to belong here 
				But something felt so wrong here 
				So I'd pray 
				I could break away 

				I'll spread my wings and I'll learn how to fly 
				I'll do what it takes till I touch the sky 
				And I'll make a wish, take a chance, make a change 
				And break away 
				Out of the darkness and into the sun 
				But, I won't forget all the ones that I love 
				I'll take a risk, take a chance, make a change 
				And break away 

				Wanna feel the warm breeze 
				Sleep under a palm tree 
				Feel the rush of the ocean 
				Get on board a fast train 
				Travel on a jet plane, far away 
				And break away 

				I'll spread my wings and I'll learn how to fly 
				I'll do what it takes till I touch the sky 
				And I'll make a wish, take a chance, make a change 
				And break away 
				Out of the darkness and into the sun 
				I won't forget all the ones that I love 
				I gotta take a risk, take a chance, make a change 
				And break away 

				Buildings with a hundred floors 
				Swinging round revolving doors 
				Maybe I don't know where they'll take me 
				But, gotta keep moving on, moving on 
				Fly away, break away 

				I'll spread my wings and I'll learn how to fly 
				Though it's not easy to tell you goodbye, gotta 
				Take a risk, take a chance, make a change 
				And break away 
				Out of the darkness and into the sun 
				But, I won't forget the place I come from 
				I gotta take a risk, take a chance, make a change 
				And break away 

				Breakaway 
				Breakaway";
		} elseif($arg1 == "Recover") {
			$expected_lyrics = "Recover
				The last one was a bit tuney 

				Carved earth, cold 
				Hiding from you in this skin, so old 
				I'll come clean 
				Everywhere everyone knows it's me 

				And if I recover 
				Will you be my comfort? 
				Or it can be over 
				Or we can just leave it here 
				So pick any number 
				Choose any color 
				I've got the answer 
				Open the envelope 

				I'll give you one more chance 
				To say we can change or part ways 
				And you take what you need 
				And you don't need me 

				I'll give you one more chance 
				To say we can change our old ways 
				And you take what you need 
				And you know you don't need me 

				Blow by blow 
				Honest in every way I know 
				You appear 
				To face a decision I know you fear 

				And if I recover 
				Will you be my comfort? 
				Or it can be over 
				Or we can just leave it here 
				So pick any number 
				Choose any color 
				I've got the answer 
				Open the envelope 

				I'll give you one more chance 
				To say we can change or part ways 
				And you take what you need 
				And you don't need me 

				I'll give you one more chance 
				To say we can change our old ways 
				And you take what you need 
				And you know you don't need me 

				And you know you don't need me 

				And if I recover 
				Will you be my comfort? 
				Or it can be over 
				Or we can just leave it here 
				So pick any number 
				Choose any color 
				I've got the answer 
				Open the envelope 

				I'll give you one more chance 
				To say we can change or part ways 
				And you take what you need 
				And you don't need me 

				I'll give you one more chance 
				To say we can change our old ways 
				And you take what you need 
				And you know you don't need me";
		}
		$session = $this->getSession();
		$page = $session->getPage();
		$lyrics = $page->findById('Lyrics')->getText();
		$lyrics = preg_replace('/\s/', '', $lyrics);
		$expected_lyrics = preg_replace('/\s/', '', $expected_lyrics);
		if ($lyrics != $expected_lyrics) {
			throw new Exception("Lyrics do not match for ".$arg1.".");
		}
	}

	/**
	 * @Then all occurances of :arg1 on the page are highlighted
	 */
	public function allOccurancesOfOnThePageAreHighlighted($arg1)
	{
		$session = $this->getSession();
		$page = $session->getPage();
		$div = $page->findById('Lyrics');
		$spans = $div->findAll('named', array('content', $arg1));
		$all_good = true;
		foreach($spans as $span) {
			if (!($span->hasAttribute('style'))) {
				$all_good = false;
				break; 
			}	
			if (!($span->getAttribute('style')=='color:yellow')) {
				$all_good = false;
				break;
			}
		}
		if (!$all_good) {
			throw new Exception("Found unhighlighted ".$arg1." on lyrics page.");
		}
	}

	/**
	 * @Then there is a popup titled :arg1
	 */
	public function thereIsAPopupTitled($arg1)
	{
		$session = $this->getSession();
		$windows = $session->getWindowNames();
		if (count($windows) < 2) { // no popup opened
			throw new Exception("No popup window opened.");
		}
		$page_title = $this->getSession()->getPage()->find('css', 'title')->getText();
		if ($page_title != $arg1) {
			throw new Exception("Page title should be ".$arg1."but is ".$page_title." instead.");
		}
	}

	/**
	 * @When I login
	 */
	public function iLogin()
	{
		$session = $this->getSession();
		$windows = $session->getWindowNames();
		if (count($windows) < 2) { // no popup opened
			throw new Exception("No popup window opened.");
		}
		$session->switchToWindow($windows[1]); 
		$page = $session->getPage();
		$page->fillField('email', 'alecschule@me.com');
		$page->fillField('pass', '');
		$page->pressButton('login');
	}

	/**
	 * @Then I am shown a filled-out facebook post
	 */
	public function iAmShownAFilledOutFacebookPost()
	{
		$session = $this->getSession();
		$windows = $session->getWindowNames();
		if (count($windows) < 2) { // no popup opened
			throw new Exception("No popup window opened.");
		}
		$session->switchToWindow($windows[1]); 
		$page = $session->getPage();
		$page_title = $this->getSession()->getPage()->find('css', 'title')->getText();
		$expected_title = "Facebook";
		if ($page_title != $expected_title) {
			throw new Exception("Current page is not facebook post page.");
		}
	}
>>>>>>> origin/alec-testing
}
