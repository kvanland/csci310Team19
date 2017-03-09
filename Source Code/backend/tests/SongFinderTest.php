<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers WordCloud
 */
final class SongFinderTest extends TestCase
{
    public function testNullArray(){
    	$sf = SongsFinder();
    	$this->assertEquals(null, $sf->getSongs("***", "You"));
    }

    public function testCorrectResultForArtist(){

    }

}