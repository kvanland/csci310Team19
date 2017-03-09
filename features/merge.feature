Feature: Merge
In order to view more than one artist at once
As a website user
I need to be able to merge specific artists

Scenario: Merge with empty search box
Given I am on the home page
When I do nothing
Then I should not be able to click add to cloud

Scenario: Merge valid artist on home page
Given I am on the home page
When I type "drake"
And I select the suggestion "Drake"
Then I should be able to click add to cloud
And the wordcloud should be displayed with title "Drake"

Scenario: Merge valid artist without fully typing
Given I am on the home page
When I type "drak"
And I select the suggestion "Drake"
Then I should be able to click add to cloud
And the wordcloud should be displayed with title "Drake"

Scenario: Merge valid artist while displaying wordcloud
Given I am on the wordcloud page
And I type "Kanye West"
And I select the suggestion "Kanye West"
Then I should be able to click add to cloud 
And the wordcloud should be displayed with title "Kanye West"

Scenario: Merge valid artist without selecting autocomplete 
Given I am on the home page
When I type "CHVRCHES"
Then I should not be able to click add to cloud

Scenario: Merge incomplete search term without selecting autocomplete
Given I am on the home page
When I type "Man"
Then I should not be able to click add to cloud

Scenario: Merge Invalid Search Term on Home
Given I am on the home page
When I type "xysfdg"
Then I should not be able to click add to cloud

Scenario: Merge Invalid Search Term while displaying wordcloud
Given I am on the wordcloud page
When I type "xhgla"
Then I should not be able to click add to cloud

