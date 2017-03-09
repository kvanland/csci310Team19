<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers WordCloud
 */
final class GetWordCloudTest extends TestCase
{
    public function testNullArray(){
    	$this->assertEquals(null, WordCloudDriver::getWordCloud(""));
    }

    public function testReturnsValidJson(){
    	json_decode(WordCloudDriver::getWordCloud("Drake"));
    	$this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    public function test250WordsAreReturnedWithMultipleArtists(){
    	$wordsJSON = WordCloudDriver::getWordCloud("Drake,Coldplay");
    	$words = json_decode($wordsJSON);
    	$this->assertEquals(250, count($words));
    }

    public function testArtistsAreInDescendingOrder(){
    	$wordsJSON = WordCloudDriver::getWordCloud("Drake,Coldplay");
    	$words = json_decode($wordsJSON, True);

    	$isDesc = true;

        for ($i = 0; $i < count($words); $i++) {
        	for ($c=$i; $c < count($words); $c++) { 
        		if ($words[$i]["size"] < $words[$c]["size"]) {
        			$isDesc = false;
        		}
        	}
        }

        $this->assertEquals(true, $isDesc);
    }

    public function testCombinedArtistProvideAccurateSummation(){
    	$wordsJSON = WordCloudDriver::getWordCloud("Drake,Coldplay");
    	$words = json_decode($wordsJSON,True);
    	$verifyYou = false;
    	$verifyWould = false;
    	for ($i=0; $i < count($words); $i++) { 
    		if ($words[$i]["text"] == "you" && $words[$i]["size"] == "70") {
    			$verifyYou = true;
    		}
    		if ($words[$i]["text"] == "would" && $words[$i]["size"] == "8") {
    			$verifyWould = true;
    		}
    	}
    	$verify = $verifyYou && $verifyWould;
    	$this->assertEquals(true, $verify);
    }


}