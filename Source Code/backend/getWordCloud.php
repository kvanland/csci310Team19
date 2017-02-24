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
$count = $wc->getOccurrences();
$sendObj = array();

for($i = 0;$i<0;$i++){
    array_push($sendObj,array("text"=>$words[$i],"size"=> $count[$i]));
}

echo json_encode($sendObj);
?>