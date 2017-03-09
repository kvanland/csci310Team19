<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers WordCloud
 */
final class SongFinderTest extends TestCase
{
    public function testNonExistingArtistReturnsNull(){
    	$songsFinder = new SongsFinder();
    	$songs = $songsFinder->getSongs("good", "***");
    	$this->assertNull($songs);
    }

    public function testExistingArtistAndValidWordReturnsCorrectArray(){
        $songsFinder = new SongsFinder();
        $songs = $songsFinder->getSongs("good", "Drake");
        $expectedArray = array("Hold On, We're Going Home"=>array(6, "Drake"), "Over"=>array(1, "Drake"));
        $this->assertEquals($expectedArray, $songs);
    }

    public function testExistingArtistButNoSongsContainingWordReturnsNull(){
        $songsFinder = new SongsFinder();
        $songs = $songsFinder->getSongs("***", "drake");
        $this->assertNull($songs);
    }



}