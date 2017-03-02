<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 5:25 PM
 */

include "LyricFinder.php";

// Http get requests from front end
$song = $_GET["song"];
$artistName = $_GET["artist"];

// Make all letters lowercase and remove all spaces to accommodate API call
$song = str_replace(' ', '', $song);
$artistName = str_replace(' ', '', $artistName);
$song = strtolower($song);
$artistName = strtolower($artistName);

// Make sure song and artistName have values
if(strlen($song) == 0 || strlen($artistName) == 0){
    echo null;
    exit(1);
}

// Create a LyricsFinder and get the Lyrics with an artist and song title
$lyricsFinder = new LyricFinder();
$lyrics = $lyricsFinder->getLyrics($artistName, $song);

// Create the associated array
$sendObj = array("lyrics"=> $lyrics);

// Turn associated array into JSON and send it to front end
echo json_encode($sendObj);