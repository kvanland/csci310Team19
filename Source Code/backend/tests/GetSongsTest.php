<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 8:58 PM
 */

use PHPUnit\Framework\TestCase;

final class GetSongsTest extends TestCase
{
    public function testGetSongsReturnsSongsArtistsAndFrequencies(){

//        $a = 3;
//        $b = 3;
//        $this->assertEquals($a,$b);
        $songsDriver = new SongsDriver();
        $songsArray = $songsDriver->getSongs("ever", "drake");
        $expectedArray = array("Best I Ever Had"=> array("drake","25"), "Forever"=> array("drake","23"),
            "Take Care"=> array("drake","2"), "Over"=> array("drake","2"));
        foreach ($expectedArray as $x => $x_value) {
            array_push($expectedJSON, array("Song" => $x, "Artist" => $x_value[0], "Frequency" => $x_value[1]));
        }
        $this->assertEquals($songsArray, json_encode($expectedArray));
    }

}