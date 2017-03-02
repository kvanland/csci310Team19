<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 4:12 PM
 */

include "ArtistSuggestions.php";

// Http get request from front end
$partialName = $_GET["artist"];

// Make sure partialName has a value
if(strlen($partialName) == 0){
    echo null;
    exit(1);
}

// Create the ArtistSuggestions object and get the artist names that contain the partial name
$suggestions = new ArtistSuggestions();
$artistNames = $suggestions->getSuggestion($partialName);
$sendObj = array();

// Check that suggestions exist
if(empty($artistNames)){
    echo null;
}
else {
    // Create the associated array
    foreach ($artistNames as $x => $x_value) {
        array_push($sendObj, array("value" => $x, "icon" => $x_value));
    }

    // Turn associated array into JSON and send it to front end
    echo json_encode($sendObj);
}

