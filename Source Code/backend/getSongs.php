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
$artistName = "drake";
$word = "you";



if(strlen($word) == 0|| strlen($artistName) == 0){
    echo null;
    exit(1);
}

$songFinder = new SongsFinder();
$songs = $songFinder->getSongs($word, $artistName);

$sendObj = array();

foreach ($songs as $x => $x_value){
    array_push($sendObj,array("song"=>$x, "artist"=>$x_value[1] ,"frequency"=> $x_value[0]));
}

echo json_encode($sendObj);
