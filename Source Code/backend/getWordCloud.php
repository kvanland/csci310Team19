<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/23/17
 * Time: 6:17 PM
 */
include "WordCloud.php";
//$artistsCSV =  "Drake,Coldplay"; *EXAMPLE*
$artistsCSV = $_GET["artists"];
$artistsCSV =  "Drake,Coldplay";
$artists = str_getcsv($artistsCSV);

if ($artists == null){
    echo null;
    exit(1);
}
$sendObj = array();

//put first artist in sendObj
$wc = new WordCloud();
$wc->createWordCloud($artists[0]);
$words = $wc->getWords();
$sendObj = array();
while($row = $words->fetch_assoc()){
    array_push($sendObj,array("text"=>$row["Word"],"size"=> $row["Occurences"]));
}

//for all artist
for ($i = 1; $i < count($artists); $i++){
    $wc2 = new WordCloud();
    $wc2->createWordCloud($artists[$i]);
    $words2 = $wc2->getWords();

    //for all words
    while($row = $words2->fetch_assoc()){
        //check and add against current list
        $found = false;
        $insertPos = 0;
        for($c = 0; $c < count($sendObj); $c++){
            // if word
            if ($sendObj[$c]["text"] == $row["Word"]){
                (int)$sendObj[$c]["size"] = (int)$sendObj[$c]["size"]+(int)$row["Occurences"];
                $found = true;
            }
            // if current occurrence is less than one in list save pos
            if ((int)$row["Occurences"] < (int)$sendObj[$c]["size"]){
                $insertPos = $c;
            }
        }
        // if not found, insert in order of occurrence
        if (!$found){
            array_splice($sendObj, $insertPos, 0,array(array("text"=>$row["Word"],"size"=> $row["Occurences"])));

        }
    }
}


//using bubble sort for optimal sorting of almost sorted lists
$size = count($sendObj);
for ($i=0; $i<$size; $i++) {
    for ($j=0; $j<$size1-$i; $j++) {
        if ((int)$sendObj[$j+1]["size"] > (int)$sendObj[$j]["size"]) {
            swap($sendObj, $j, $j+1);
        }
    }
}


//return 250
$sendObj =  array_chunk($sendObj,250)[0];

echo json_encode($sendObj);

// used for swapping in bubble sort
function swap(&$arr, $a, $b) {
    $tmp = $arr[$a];
    $arr[$a] = $arr[$b];
    $arr[$b] = $tmp;
}
?>