Feature: Nonfunctional requirements
    In order to meet stakeholder requirements
    As a developer
    I must test nonfunctional requirements

    @javascript
    Scenario: Artist Search Page gray background
        Given the current page is "Of Monsters and Men" artist search page
        When I click "Share to Facebook"
        Then there is a popup titled "Log in With Facebook"
