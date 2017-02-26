<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/23/17
 * Time: 6:17 PM
 */
$artist = $_GET["artist"];

if(strlen($artist = 0)){
    echo null;
    exit(1);
}

$wc = new WordCloud();
$wc->createWordCloud($artist);
$words =  $wc->getWords();

$sendObj = array();

while($row = $words->fetch_assoc()){
    array_push($sendObj,array("text"=>$row["Word"],"size"=> $row["Occurences"]));
}


echo json_encode($sendObj);
?>