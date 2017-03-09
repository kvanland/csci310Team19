Feature: Share to Facebook Button
    In order to share my wordcloud with others
    As a user
    I need to be able to easily share the wordcloud on facebook

    @javascript
    Scenario: Test facebook login window appears
        Given the current page is "Of Monsters and Men" word cloud
        When I click "Share to Facebook"
        Then there is a popup titled "Log in With Facebook"

    @javascript
    Scenario: Check facebook post
        Given the current page is "Of Monsters and Men" word cloud
        When I click "Share to Facebook"
        And I login
        Then I am shown a filled-out facebook post
