Feature: Song lyrics page
    In order to understand why a wordcloud is as it is
    As a user
    I need to be able to see the full lyrics for a song

    @javascript
    Scenario: Viewing lyrics for Kelly Clarkson's Breakaway
        Given the current page is "Kelly Clarkson song list"
        And the highlighted word is "fly"
        When I click "Breakaway"
        Then the new current page is "Breakaway lyrics"
        And the page contents are the lyrics to "Breakaway"
        And all occurances of "fly" on the page are highlighted

    @javascript
    Scenario: Viewing lyrics for CHVRCHES' Recover
        Given the current page is "CHVRCHES song list"
        And the highlighted word is "number"
        When I click "Recover"
        Then the new current page is "Recover lyrics"
        And the page contents are the lyrics to "Recover"
        And all occurances of "number" on the page are highlighted
