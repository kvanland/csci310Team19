Feature: Song lyrics page
    In order to understand why a wordcloud is as it is
    As a user
    I need to be able to see the full lyrics for a song

    @javascript
    Scenario: Check Kelly Clarkson lyric page title
        Given the current page is "Kelly Clarkson" word cloud
        When I click "fly"
        And I click "Breakaway"
        Then the page title is "Breakaway" by "Kelly Clarkson"

    @javascript
    Scenario: Check Breakaway lyrics content requirement
        Given the current page is "Kelly Clarkson" word cloud
        When I click "fly"
        And I click "Breakaway"
        Then the page contents are the lyrics to "Breakaway"

    @javascript
    Scenario: Check fly lyric highlighting
        Given the current page is "Kelly Clarkson" word cloud
        When I click "fly"
        And I click "Breakaway"
        And all occurances of "fly" on the page are highlighted

    @javascript
    Scenario: Check CHVRCHES lyrics page title
        Given the current page is "CHVRCHES" word cloud
        When I click "fly"
        And I click "Breakaway"
        Then the page title is "Recover" by "CHVRCHES"

    @javascript
    Scenario: Check Recover lyrics content requirement
        Given the current page is "CHVRCHES" word cloud
        When I click "number"
        And I click "Recover"
        Then the page contents are the lyrics to "Recover"

    @javascript
    Scenario: Check number lyric highlighting
        Given the current page is "CHVRCHES" word cloud
        When I click "number"
        And I click "Recover"
        And all occurances of "number" on the page are highlighted
