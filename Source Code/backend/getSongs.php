<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 3:55 PM
 */

include "SongsFinder.php";

$word = $_GET["word"];
$artistNames = $_GET["artist"];



if(strlen($word) == 0|| strlen($artistNames) == 0){
    echo null;
    exit(1);
}

$songFinder = new SongsFinder();
$songs = array();
for ($i = 0; $i < count($artistNames); $i++){
    $oneArtist = array();
    $oneArtist = $songFinder->getSongs($word, $artistNames[$i]);
    if(null != $oneArtist) {
        $songs = array_merge($songs, $oneArtist);
    }
}

$sendObj = array();

foreach ($songs as $x => $x_value){
    array_push($sendObj,array("song"=>$x,"frequency"=> $x_value[0], "artist"=>$x_value[1]));
}

echo json_encode($sendObj);
