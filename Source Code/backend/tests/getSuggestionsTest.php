<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 10:21 PM
 */

use PHPUnit\Framework\TestCase;

final class getSuggestionsTest extends TestCase
{
    public function testReturnsValidJson()
    {
        json_decode(SuggestionsDriver::getSuggestions("dra"));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    public function testReturnsNullIfNoSuggestions(){
        $array =  SuggestionsDriver::getSuggestions("xfv");
        $this->assertNull($array);
    }

    public function testReturnsNullIfEmptyString(){
        $array =  SuggestionsDriver::getSuggestions("");
        $this->assertNull($array);
    }
}