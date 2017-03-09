Feature:
    In order to navigate back from other pages
    As a website user
    I should be able to navigate to the previous page

    Scenario: Back on Word Cloud page
        Given the current page is "http://localhost"
        When I search for "Drake"
        And I click on the "back" button
        Then I should be at the Artist Search page
        
    Scenario: Back on Song List page
        Given the current page is "http://localhost"
        When I search for "Drake"
        And I select the word "ever"
        And I click on the "back" button
        Then I should be at the Word Cloud Page

    Scenario: Back on Lyric page
    	Given the current page is "http://localhost"
    	When I search for "Drake"
    	And I select the word "ever"
    	And I click on the song "Forever"
    	And I click on the "back" button
    	Then I should be at the Song List