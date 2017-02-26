<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 5:25 PM
 */

$song = $_GET["song"];
$artistName = $_GET["artist"];

if(strlen($song = 0)|| strlen($artistName = 0)){
    echo null;
    exit(1);
}

$lyricsFinder = new LyricFinder();
$lyrics = $lyricsFinder->getLyrics($song, $artistName);
$sendObj = array("lyrics"=> $lyrics);


echo json_encode($sendObj);