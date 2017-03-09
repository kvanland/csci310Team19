<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 3:55 PM
 */

include "SongsFinder.php";


// Http get requests from front end
$word = $_GET["word"];
$artistName = $_GET["artist"];


echo SongsDriver::getSongs($word, $artistName);

class SongsDriver
{
    public static function getSongs($word, $artistName){
        // Make sure word and artistName have values
        if (strlen($word) == 0|| strlen($artistName) == 0)
        {
            echo null;
            exit(1);
        }

        // Create the SongsFinder and get the songs of an artist that contain a specified word
        $songFinder = new SongsFinder();
        $songs = $songFinder->getSongs($word, $artistName);

        $sendObj = array();

        // Create the associated array
        foreach ($songs as $x => $x_value) {
            array_push($sendObj, array("Song" => $x, "Artist" => $x_value[1], "Frequency" => $x_value[0]));
        }

        // Turn associated array into JSON and send it to front end
        return json_encode($sendObj);
    }

}
