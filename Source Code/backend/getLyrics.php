<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 5:25 PM
 */

include "LyricFinder.php";

$song = $_GET["song"];
$artistName = $_GET["artist"];


$song = str_replace(' ', '', $song);
$artistName = str_replace(' ', '', $artistName);
$song = strtolower($song);
$artistName = strtolower($artistName);


if(strlen($song) == 0 || strlen($artistName) == 0){
    echo null;
    exit(1);
}

$lyricsFinder = new LyricFinder();
$lyrics = $lyricsFinder->getLyrics($artistName, $song);


echo $lyrics;