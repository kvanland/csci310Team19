<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 10:47 PM
 */

use PHPUnit\Framework\TestCase;

class getSongsTest extends TestCase
{

    public function testReturnsValidJsonIfThereIsAreSongs()
    {
        json_decode(SongsDriver::getSongs("ever", "drake"));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    public function testReturnsNullIfNoSongsAreFound(){
        $array =  SongsDriver::getSongs("gg", "ogo");
        $this->assertNull($array);
    }

    public function testReturnsNullIfWordIsEmpty(){
        $array =  SongsDriver::getSongs("", "Drake");
        $this->assertNull($array);
    }

    public function testReturnsNullIfArtistIsEmpty(){
        $array =  SongsDriver::getSongs("Ever", "");
        $this->assertNull($array);
    }

    public function testReturnsNullIfBothAreEmpty(){
        $array =  SongsDriver::getSongs("", "");
        $this->assertNull($array);
    }

}