<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 4:12 PM
 */

include "ArtistSuggestions.php";

$partialName = $_GET["artist"];

$partialName = "xvf";

if(strlen($partialName) == 0){
    echo null;
    exit(1);
}

$suggestions = new ArtistSuggestions();
$artistNames = $suggestions->getSuggestion($partialName);
$sendObj = array();


if(!empty($suggestions)){
    echo null;
}

else {
    foreach ($artistNames as $x => $x_value) {
        array_push($sendObj, array("value" => $x, "icon" => $x_value));
    }
    echo json_encode($sendObj);
}

