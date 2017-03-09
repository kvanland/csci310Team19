Feature: Search
    In order to get correct information
    As a website user
    I need to be able to search by specific artists

    @javascript
    Scenario: Search with empty search box
        Given I am on the home page
        When I do nothing
        Then I should not be able to click search

    @javascript
    Scenario: Search drake on home page
        Given I am on the home page
        When I type "drake"
        And I select the suggestion "Drake"
        Then I should be able to click search
        And the wordcloud should be displayed with title "Drake"

    @javascript
    Scenario: Search drake without fully typing
        Given I am on the home page
        When I type "drak"
        And I select the suggestion "Drake"
        Then I should be able to click search
        And the wordcloud should be displayed with title "Drake"

    @javascript
    Scenario: Search for yung lean while displaying wordcloud
        Given I am on the wordcloud page
        And I type "kanye west"
        And I select the suggestion "Kanye West"
        Then I should be able to click search 
        And the wordcloud should be displayed with title "Kanye West"

    @javascript
    Scenario: Valid search term without selecting autocomplete
        Given I am on the home page
        When I type "CHVRCHES"
        Then I should not be able to click search

    @javascript
    Scenario: Incomplete search term without selecting autocomplete
        Given I am on the home page
        When I type "Man"
        Then I should not be able to click search

    @javascript
    Scenario: Invalid Search Term
        Given I am on the home page
        When I type "xysfdg"
        Then I should not be able to click search

