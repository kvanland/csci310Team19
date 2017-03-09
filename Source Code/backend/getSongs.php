<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 11:08 PM
 */

include "SongsFinder.php";

$clickedWord = $_GET["word"];
$artist = $_GET["artist"];


echo SongsDriver::getSongs($clickedWord, $artist);

class SongsDriver{
    public static function getSongs($word, $artistName){
        // Make sure word and artistName have values
        if (strlen($word) == 0|| strlen($artistName) == 0){
            return null;
        }
        // Create the SongsFinder and get the songs of an artist that contain a specified word
        $songFinder = new SongsFinder();
        $songs = $songFinder->getSongs($word, $artistName);

        $sendObj = array();


        if($songs == null)
            return null;
        // Create associated array
        foreach ($songs as $x => $x_value){
            array_push($sendObj, array("Song" => $x, "Artist" => $x_value[1], "Frequency" => $x_value[0]));
        }
        // Turn associated array into JSON and send it to front end
        return json_encode($sendObj);
    }
}