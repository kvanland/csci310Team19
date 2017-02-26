<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 3:55 PM
 */

$word = $_GET["word"];
$artistName = $_GET["artist"];

if(strlen($word = 0)|| strlen($artistName = 0)){
    echo null;
    exit(1);
}

$songFinder = new SongsFinder();
$songs = $songFinder->getSongs($word, $artistName);
$sendObj = array();

foreach ($songs as $x => $x_value){
    array_push($sendObj,array("song"=>$x,"frequency"=> $x_value));
}

echo json_encode($sendObj);
