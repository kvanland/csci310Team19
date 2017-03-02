<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 3:55 PM
 */

include "SongsFinder.php";

$word = $_GET["word"];
$artistName = $_GET["artist"];




if(strlen($word) == 0|| strlen($artistName) == 0){
    echo null;
    exit(1);
}

$songFinder = new SongsFinder();
$songs = $songFinder->getSongs($word, $artistName);

$sendObj = array();

foreach ($songs as $x => $x_value){
    array_push($sendObj,array("Song"=>$x, "Artist"=>$x_value[1] ,"Frequency"=> $x_value[0]));
}

echo json_encode($sendObj);
