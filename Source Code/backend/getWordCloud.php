<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/23/17
 * Time: 6:17 PM
 */
include "WordCloud.php";
//$artistsCSV =  "Drake,Coldplay,Rihanna,Kendrick Lamar,Radiohead"; *EXAMPLE*
$artistsCSV = $_GET["artists"];
$artists = str_getcsv($artistsCSV);

if ($artists == null){
    echo null;
    exit(1);
}

$wordToCountHM = array();
//for all the artists
for ($i = 0; $i < count($artists); $i++){
    $wc = new WordCloud();
    $wc->createWordCloud($artists[$i]);
    $words = $wc->getWords();
    //for all words
    while($row = $words->fetch_assoc()){
        //put in hash or add
        if ($count = $wordToCountHM[$row["Word"]]){
            $wordToCountHM[$row["Word"]] = $count + $row["Occurences"];
        } else {
            $wordToCountHM[$row["Word"]] = $row["Occurences"];
        }
    }
}
//sort in descending order
arsort($wordToCountHM);

$sendObj = array();
//put in format
foreach ($wordToCountHM as $key => $value){
    array_push($sendObj,array("text"=>$key,"size"=> $value));
}

//return 250
$sendObj =  array_chunk($sendObj,250)[0];

echo json_encode($sendObj);
?>