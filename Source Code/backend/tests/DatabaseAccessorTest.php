<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 4:38 PM
 */
use PHPUnit\Framework\TestCase;

final class DatabaseAccessorTest extends TestCase
{
    public function testConnectionToDatabase(){
        $dbAccessor = new DatabaseAccesor();
        $this->assertNotNull($dbAccessor);
    }

    public function testCanGetArtistIdWithValidArtist(){
        $dbAccesor = new DatabaseAccesor();
        $artistName = "Rihanna";
        $artistID =  $dbAccesor->getArtistID($artistName);
        $this->assertEquals(7, $artistID);
    }

    public function  testReturnsNullWithInvalidArtist(){
        $dbAccesor = new DatabaseAccesor();
        $artistName = "Brodie";
        $artistID =  $dbAccesor->getArtistID($artistName);
        $this->assertNull($artistID);
    }

}