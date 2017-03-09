Feature: Song List 
    In order to see more information about an artist
    As a website user
    I need to see the number of occurances of a word in all of my chosen artists' songs
    
    Scenario: Artist "Bleachers" word "gave"
        Given the current page is "http://localhost/"
        When I search for "Bleachers"
        And I select the word "gave"
        Then I should see the songs "Shadow" and "I Wanna Get Better" with respective frequencies of "2" and "1"

    Scenario: Artist "Drake" word "mine"
    	Given the current page is "http://localhost/"
    	When I search for "Drake"
    	And I select the word "mine"
    	Then I should see the word "mine" at the top of the screen

    Scenario: Artist "Kanye West" word "go"
        Given the current page is "http://localhost/"
        When I search for "Kanye West"
        And I select the word "go"
        Then I should see the songs listed in descending frequency


