Feature:
    In order to navigate back from other pages
    As a website user
    I should be able to navigate to the Word Cloud page or Artist Search page

    Scenario: Home on Word Cloud page
        Given the current page is "http://localhost"
        When I search for "Drake"
        And I click on the "home" button
        Then I should be at the Artist Search page
        
    Scenario: Home on Song List page
        Given the current page is "http://localhost"
        When I search for "Drake"
        And I select the word "ever"
        And I click on the "home" button
        Then I should be at the Word Cloud Page

    Scenario: Home on Lyric page
    	Given the current page is "http://localhost"
    	When I search for "Drake"
    	And I select the word "ever"
    	And I click on the song "Forever"
    	And I click on the "home" button
    	Then I should be at the Word Cloud Page