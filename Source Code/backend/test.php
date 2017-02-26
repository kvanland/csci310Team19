<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/24/17
 * Time: 5:40 PM
 */
include 'WordCloud.php';
$wc = new WordCloud();
$wc->createWordCloud("Drake");
$words = $wc->getWords();
$sendObj = array();
while($row = $words->fetch_assoc()){
    array_push($sendObj,array("text"=>$row["Word"],"size"=> $row["Occurences"]));
}
echo json_encode($sendObj);

?>