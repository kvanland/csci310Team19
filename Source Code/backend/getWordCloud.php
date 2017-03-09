<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/23/17
 * Time: 6:17 PM
 */
include "WordCloud.php";
// $artistsCSV =  "Drake,Coldplay,Rihanna,Kendrick Lamar,Radiohead";
$artistsCSV = $_GET["artists"];



echo WordCloudDriver::getWordCloud($artistsCSV);

class WordCloudDriver
{
    public static function getWordCloud($artistsStr){
        $artists = str_getcsv($artistsStr);

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
                if (array_key_exists($row["Word"], $wordToCountHM)){
                    $wordToCountHM[$row["Word"]] = $wordToCountHM[$row["Word"]] + $row["Occurences"];
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

        return json_encode($sendObj);
    }

}