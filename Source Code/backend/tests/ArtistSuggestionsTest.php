<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 4:43 PM
 */

use PHPUnit\Framework\TestCase;

final class ArtistSuggestionsTest extends TestCase
{
    public function testGetSuggestionWorks(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "Dra";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Drake"=> "https://lastfm-img2.akamaized.net/i/u/174s/b4310b8ad99f2b5930b36725bb7deb36.png",
        "Dragonette" => "https://lastfm-img2.akamaized.net/i/u/174s/20bb4ca71fbf4991990cacec6074a90a.png",
        "Draper"=> "https://lastfm-img2.akamaized.net/i/u/174s/14511d935336413883d47e60e55422a4.png",
        "DragonForce"=> "https://lastfm-img2.akamaized.net/i/u/174s/fbbdb94a245043edb56b0f50e413d565.png",
        "Dramarama"=> "https://lastfm-img2.akamaized.net/i/u/174s/a384389858214653b60464c57b72c229.png");
        $this->assertEquals($names, $expectedNames);
    }

    public function testGetSuggestionWorksWithAllLowerCaseString(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "dra";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Drake"=> "https://lastfm-img2.akamaized.net/i/u/174s/b4310b8ad99f2b5930b36725bb7deb36.png",
            "Dragonette" => "https://lastfm-img2.akamaized.net/i/u/174s/20bb4ca71fbf4991990cacec6074a90a.png",
            "Draper"=> "https://lastfm-img2.akamaized.net/i/u/174s/14511d935336413883d47e60e55422a4.png",
            "DragonForce"=> "https://lastfm-img2.akamaized.net/i/u/174s/fbbdb94a245043edb56b0f50e413d565.png",
            "Dramarama"=> "https://lastfm-img2.akamaized.net/i/u/174s/a384389858214653b60464c57b72c229.png");
        $this->assertEquals($names, $expectedNames);
    }

    public function testGetSuggestionWorksWithAllUpperCaseString(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "DRA";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Drake"=> "https://lastfm-img2.akamaized.net/i/u/174s/b4310b8ad99f2b5930b36725bb7deb36.png",
            "Dragonette" => "https://lastfm-img2.akamaized.net/i/u/174s/20bb4ca71fbf4991990cacec6074a90a.png",
            "Draper"=> "https://lastfm-img2.akamaized.net/i/u/174s/14511d935336413883d47e60e55422a4.png",
            "DragonForce"=> "https://lastfm-img2.akamaized.net/i/u/174s/fbbdb94a245043edb56b0f50e413d565.png",
            "Dramarama"=> "https://lastfm-img2.akamaized.net/i/u/174s/a384389858214653b60464c57b72c229.png");
        $this->assertEquals($names, $expectedNames);
    }

    public function testPartialNameThatBeginsMoreThan5ArtistsNamesReturnsOnly5Names(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "bea";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Beach House"=> "https://lastfm-img2.akamaized.net/i/u/174s/7fca68251e01485eb46f2de4acb712da.png",
            "Beastie Boys"=> "https://lastfm-img2.akamaized.net/i/u/174s/48bebf1d288f47bdb02a3436a90e0d9d.png",
            "Beach Fossils"=> "https://lastfm-img2.akamaized.net/i/u/174s/419d30d6c2aa42cfa46a86ad9e3862f0.png",
            "Bear's Den"=> "https://lastfm-img2.akamaized.net/i/u/174s/ffca5f059f574ce993531ac754f0816f.png",
            "Bear Hands"=> "https://lastfm-img2.akamaized.net/i/u/174s/fd64c055788d4eadcec865dcf4253e5c.png");
        $this->assertEquals($names, $expectedNames);
    }

    public function testCanGetBackArtistNameWithTwoWords(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "kan";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Kanye West"=> "https://lastfm-img2.akamaized.net/i/u/174s/2377da54b28a610cb20cbc2b9c5a7517.png",
            "Kansas"=>"https://lastfm-img2.akamaized.net/i/u/174s/ba357970b9ef42adbc2f5f4af2417ee5.png",
            "Kano"=>"https://lastfm-img2.akamaized.net/i/u/174s/89d80e0b29e04cc187925683b3c6f6cc.png",
            "Kan Wakan"=>"https://lastfm-img2.akamaized.net/i/u/174s/d44149116bf94613c6decfcfaeb3a265.png",
            "Kangding Ray"=> "https://lastfm-img2.akamaized.net/i/u/174s/91315f92a29d4b3a9e0b27274d68c014.png");
        $this->assertEquals($names, $expectedNames);
        
    }

    public function testPassingInTheFullNameOfAnExistingArtist(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "kanye west";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("Kanye West" =>"https://lastfm-img2.akamaized.net/i/u/174s/2377da54b28a610cb20cbc2b9c5a7517.png");
        $this->assertEquals($names, $expectedNames);
    }

    public function testCanReturnArtistsWhenPartialNameIsMadeOfTwoWords(){
        $artistSuggestions = new ArtistSuggestions();
        $partialName = "the bea";
        $names = $artistSuggestions->getSuggestion($partialName);
        $expectedNames = array("The Beatles" =>"https://lastfm-img2.akamaized.net/i/u/174s/6c9cdd81b0ba4c198d47d13f200bc843.png",
        "The Beach Boys" =>"https://lastfm-img2.akamaized.net/i/u/174s/f902c00cdd234924a38c151e7684cfbb.png",
        "The Beatnuts" =>"https://lastfm-img2.akamaized.net/i/u/174s/cefe72c5d5f94f4fab5baacf09119285.png",
        "The Beau Brummels" =>"https://lastfm-img2.akamaized.net/i/u/174s/da2157bfef9d4bff49dd7786bc05c8df.png");
        $this->assertEquals($names, $expectedNames);
    }
}